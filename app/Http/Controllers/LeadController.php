<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadActivity;
use App\Models\User;
use App\Models\Course;
use App\Models\Branch;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Enrolment;
use App\Models\StudentInvoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with(['source', 'assignedUser', 'branch']);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->source_id) {
            $query->where('lead_source_id', $request->source_id);
        }
        if ($request->counsellor_id) {
            $query->where('assigned_to_user_id', $request->counsellor_id);
        }
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('parent_name', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $leads = $query->latest()->paginate(15);
        $sources = LeadSource::all();
        $counsellors = User::whereIn('role', ['counsellor', 'admin'])->get();
        $courses = Course::all();
        $branches = Branch::all();

        return view('crm.leads.index', compact('leads', 'sources', 'counsellors', 'courses', 'branches'));
    }

    public function pipeline()
    {
        $leads = Lead::with(['source', 'assignedUser'])->latest()->get();
        $sources = LeadSource::all();
        $counsellors = User::whereIn('role', ['counsellor', 'admin'])->get();
        $courses = Course::all();

        $columns = [
            'new_enquiry' => ['title' => 'New Enquiry', 'color' => 'primary', 'leads' => $leads->where('status', 'new_enquiry')],
            'contact_pending' => ['title' => 'Contact Pending', 'color' => 'warning', 'leads' => $leads->where('status', 'contact_pending')],
            'contacted' => ['title' => 'Contacted', 'color' => 'info', 'leads' => $leads->where('status', 'contacted')],
            'interested' => ['title' => 'Interested', 'color' => 'teal', 'leads' => $leads->where('status', 'interested')],
            'counselling_scheduled' => ['title' => 'Counselling Scheduled', 'color' => 'purple', 'leads' => $leads->where('status', 'counselling_scheduled')],
            'followup_required' => ['title' => 'Follow-up Due', 'color' => 'orange', 'leads' => $leads->where('status', 'followup_required')],
            'admission_confirmed' => ['title' => 'Admission Confirmed', 'color' => 'success', 'leads' => $leads->where('status', 'admission_confirmed')],
            'lost_lead' => ['title' => 'Lost / Cold', 'color' => 'danger', 'leads' => $leads->where('status', 'lost_lead')],
        ];

        return view('crm.leads.pipeline', compact('columns', 'sources', 'counsellors', 'courses'));
    }

    public function followups()
    {
        $today = Carbon::today()->toDateString();
        $overdue = Lead::whereDate('followup_date', '<', $today)
            ->whereNotIn('status', ['admission_confirmed', 'lost_lead'])
            ->with(['assignedUser', 'source'])
            ->orderBy('followup_date', 'asc')
            ->get();

        $todayFollowups = Lead::whereDate('followup_date', $today)
            ->whereNotIn('status', ['admission_confirmed', 'lost_lead'])
            ->with(['assignedUser', 'source'])
            ->orderBy('followup_time', 'asc')
            ->get();

        $upcoming = Lead::whereDate('followup_date', '>', $today)
            ->whereNotIn('status', ['admission_confirmed', 'lost_lead'])
            ->with(['assignedUser', 'source'])
            ->orderBy('followup_date', 'asc')
            ->take(20)
            ->get();

        return view('crm.leads.followups', compact('overdue', 'todayFollowups', 'upcoming'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_name' => 'required|string|max:150',
            'mobile' => 'required|string|max:20',
        ]);

        $cleanMobile = preg_replace('/[^0-9]/', '', $request->mobile);
        $duplicate = Lead::where('mobile', 'like', "%{$cleanMobile}%")->first();

        $lead = Lead::create([
            'parent_name' => $request->parent_name,
            'student_name' => $request->student_name,
            'mobile' => $cleanMobile,
            'whatsapp' => $request->whatsapp ?: $cleanMobile,
            'email' => $request->email,
            'student_age' => $request->student_age,
            'current_school' => $request->current_school,
            'current_class' => $request->current_class,
            'city' => $request->city ?: 'Noida / NCR',
            'location' => $request->location,
            'course_interest' => $request->course_interest,
            'lead_source_id' => $request->lead_source_id,
            'assigned_to_user_id' => $request->assigned_to_user_id ?: Auth::id(),
            'branch_id' => $request->branch_id ?: 1,
            'status' => $request->status ?: 'new_enquiry',
            'notes' => $request->notes,
            'followup_date' => $request->followup_date,
            'followup_time' => $request->followup_time,
            'followup_notes' => $request->followup_notes,
            'is_duplicate' => (bool)$duplicate,
            'duplicate_of_lead_id' => $duplicate ? $duplicate->id : null,
        ]);

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => 'note',
            'title' => 'Lead Created Manually',
            'description' => 'Lead created in system by ' . (Auth::user() ? Auth::user()->name : 'Staff') . ($duplicate ? ' (Possible duplicate of Lead #'.$duplicate->id.')' : ''),
        ]);

        return back()->with('success', 'Lead ' . $lead->parent_name . ' added successfully!' . ($duplicate ? ' Warning: Potential duplicate phone number!' : ''));
    }

    public function show($id)
    {
        $lead = Lead::with(['source', 'assignedUser', 'branch', 'activities.user', 'counsellingAppointments.counsellor'])->findOrFail($id);
        $counsellors = User::whereIn('role', ['counsellor', 'admin'])->get();
        $courses = Course::all();

        return view('crm.leads.show', compact('lead', 'counsellors', 'courses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $oldStatus = $lead->status;
        $newStatus = $request->status;

        $lead->status = $newStatus;
        if ($request->followup_date) {
            $lead->followup_date = $request->followup_date;
            $lead->followup_time = $request->followup_time;
            $lead->followup_notes = $request->followup_notes;
        }
        $lead->save();

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => 'status_change',
            'title' => 'Status Changed to ' . ucfirst(str_replace('_', ' ', $newStatus)),
            'description' => $request->notes ?: "Status changed from {$oldStatus} to {$newStatus}.",
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Lead status updated to ' . ucfirst(str_replace('_', ' ', $newStatus)));
    }

    public function addActivity(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => $request->type ?: 'call',
            'title' => $request->title ?: 'Follow-up Interaction',
            'description' => $request->description,
        ]);

        if ($request->followup_date) {
            $lead->followup_date = $request->followup_date;
            $lead->followup_time = $request->followup_time;
            $lead->followup_notes = $request->description;
            $lead->save();
        }

        return back()->with('success', 'Activity and call note recorded successfully.');
    }

    public function assign(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->assigned_to_user_id = $request->assigned_to_user_id;
        $lead->save();

        $user = User::find($request->assigned_to_user_id);

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => 'note',
            'title' => 'Lead Assigned',
            'description' => 'Assigned to ' . ($user ? $user->name : 'Unassigned'),
        ]);

        return back()->with('success', 'Lead assigned successfully.');
    }

    public function convertToStudent(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        // 1. Find or create Parent Profile
        $parent = ParentModel::where('primary_mobile', $lead->mobile)->first();
        if (!$parent) {
            $parent = ParentModel::create([
                'father_name' => $lead->parent_name,
                'primary_mobile' => $lead->mobile,
                'whatsapp_number' => $lead->whatsapp ?: $lead->mobile,
                'email' => $lead->email,
                'city' => $lead->city,
                'address' => $lead->location,
            ]);
        }

        // 2. Generate Student ID
        $nextId = Student::count() + 1;
        $studentIdNumber = 'TG-' . date('Y') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // 3. Create Student
        $student = Student::create([
            'student_id_number' => $studentIdNumber,
            'parent_id' => $parent->id,
            'branch_id' => $lead->branch_id ?: 1,
            'first_name' => $lead->student_name ?: $lead->parent_name . ' Child',
            'age' => $lead->student_age,
            'school_name' => $lead->current_school,
            'current_class' => $lead->current_class,
            'city' => $lead->city,
            'admission_date' => Carbon::now()->toDateString(),
            'status' => 'active',
        ]);

        // 4. If course specified, create Enrolment
        $courseId = $request->course_id;
        if (!$courseId) {
            $course = Course::where('name', 'like', "%{$lead->course_interest}%")->first() ?? Course::first();
            $courseId = $course ? $course->id : null;
        }

        if ($courseId) {
            $course = Course::find($courseId);
            $fee = $course->course_fee;
            $enrolNumber = 'ENR-' . date('Y') . '-' . str_pad(Enrolment::count() + 1, 3, '0', STR_PAD_LEFT);

            $enrolment = Enrolment::create([
                'enrolment_number' => $enrolNumber,
                'student_id' => $student->id,
                'course_id' => $course->id,
                'branch_id' => $lead->branch_id ?: 1,
                'counsellor_id' => $lead->assigned_to_user_id ?: Auth::id(),
                'admission_date' => Carbon::now()->toDateString(),
                'start_date' => Carbon::now()->addDays(2)->toDateString(),
                'total_fee' => $fee,
                'discount_amount' => 0,
                'final_payable' => $fee,
                'paid_amount' => 0,
                'due_balance' => $fee,
                'status' => 'active',
            ]);

            // Create Invoice
            StudentInvoice::create([
                'invoice_number' => 'INV-' . date('Y') . '-' . str_pad(StudentInvoice::count() + 1, 3, '0', STR_PAD_LEFT),
                'enrolment_id' => $enrolment->id,
                'student_id' => $student->id,
                'parent_id' => $parent->id,
                'title' => 'Course Fee - ' . $course->name,
                'total_amount' => $fee,
                'final_payable' => $fee,
                'balance_due' => $fee,
                'invoice_date' => Carbon::now()->toDateString(),
                'due_date' => Carbon::now()->addDays(7)->toDateString(),
                'status' => 'unpaid',
            ]);
        }

        // 5. Update Lead Status
        $lead->status = 'admission_confirmed';
        $lead->converted_student_id = $student->id;
        $lead->save();

        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => 'status_change',
            'title' => 'Admission Confirmed!',
            'description' => "Converted to registered student {$student->first_name} (ID: {$student->student_id_number}).",
        ]);

        return redirect()->route('crm.students.show', $student->id)->with('success', "Lead successfully converted to registered Student {$student->student_id_number}!");
    }
}
