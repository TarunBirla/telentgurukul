<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounsellingAppointment;
use App\Models\Lead;
use App\Models\User;
use App\Models\Course;
use App\Models\LeadActivity;
use App\Models\CommunicationLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CounsellingController extends Controller
{
    public function index(Request $request)
    {
        $query = CounsellingAppointment::with(['lead', 'counsellor', 'student']);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->date) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date', 'asc')->paginate(15);
        $counsellors = User::whereIn('role', ['counsellor', 'admin'])->get();
        $leads = Lead::whereNotIn('status', ['admission_confirmed', 'lost_lead'])->get();
        $courses = Course::all();

        return view('crm.counselling.index', compact('appointments', 'counsellors', 'leads', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
        ]);

        $lead = Lead::findOrFail($request->lead_id);
        $counsellorId = $request->counsellor_id ?: ($lead->assigned_to_user_id ?: Auth::id());

        $appointment = CounsellingAppointment::create([
            'lead_id' => $lead->id,
            'counsellor_id' => $counsellorId,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'mode' => $request->mode ?: 'offline',
            'status' => 'scheduled',
            'parent_concerns' => $request->parent_concerns,
            'student_interests' => $request->student_interests,
            'recommended_program' => $request->recommended_program,
            'admission_probability' => $request->admission_probability ?: 50,
            'counsellor_remarks' => $request->counsellor_remarks,
        ]);

        $lead->status = 'counselling_scheduled';
        $lead->preferred_counselling_date = $request->appointment_date;
        $lead->preferred_counselling_time = $request->appointment_time;
        $lead->save();

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => 'meeting',
            'title' => 'Counselling Appointment Booked',
            'description' => "Scheduled for {$request->appointment_date} at {$request->appointment_time} ({$request->mode}).",
        ]);

        // WhatsApp Confirmation Log
        CommunicationLog::create([
            'channel' => 'whatsapp',
            'recipient_type' => 'lead',
            'recipient_id' => $lead->id,
            'recipient_phone_or_email' => $lead->mobile,
            'template_name' => 'counselling_confirmation',
            'message_content' => "Dear {$lead->parent_name}, your Free Brain Counselling appointment for {$lead->student_name} is confirmed on {$request->appointment_date} at {$request->appointment_time}. Mode: {$request->mode}. Talent Gurukul India.",
            'status' => 'sent',
            'sent_by_user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Counselling appointment booked and confirmation sent!');
    }

    public function recordOutcome(Request $request, $id)
    {
        $appointment = CounsellingAppointment::findOrFail($id);
        $appointment->status = $request->status ?: 'completed';
        $appointment->parent_concerns = $request->parent_concerns;
        $appointment->student_interests = $request->student_interests;
        $appointment->recommended_program = $request->recommended_program;
        $appointment->outcome = $request->outcome;
        $appointment->admission_probability = $request->admission_probability ?: 50;
        $appointment->counsellor_remarks = $request->counsellor_remarks;
        $appointment->next_followup_date = $request->next_followup_date;
        $appointment->save();

        if ($appointment->lead) {
            $lead = $appointment->lead;
            if ($request->status === 'completed') {
                $lead->status = 'counselling_completed';
            } elseif ($request->status === 'no_show') {
                $lead->status = 'followup_required';
            }
            if ($request->next_followup_date) {
                $lead->followup_date = $request->next_followup_date;
            }
            $lead->save();

            LeadActivity::create([
                'lead_id' => $lead->id,
                'user_id' => Auth::id(),
                'type' => 'meeting',
                'title' => 'Counselling Session ' . ucfirst($appointment->status),
                'description' => "Outcome: {$appointment->outcome} | Remarks: {$appointment->counsellor_remarks} | Prob: {$appointment->admission_probability}%",
            ]);
        }

        return back()->with('success', 'Counselling session notes and outcome updated successfully.');
    }
}
