<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CoursePackage;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadActivity;
use App\Models\CommunicationLog;
use App\Models\User;
use Carbon\Carbon;

class FrontendController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_active', true)->get();
        $packages = CoursePackage::where('is_active', true)->get();
        return view('frontend.index', compact('courses', 'packages'));
    }

    public function submitEnquiry(Request $request)
    {
        $validated = $request->validate([
            'parent_name' => 'required|string|max:150',
            'mobile' => 'required|string|max:20',
            'student_name' => 'nullable|string|max:150',
            'student_age' => 'nullable|numeric|min:3|max:25',
            'course_interest' => 'required|string',
            'city' => 'nullable|string|max:100',
            'preferred_counselling_date' => 'nullable|date',
            'preferred_counselling_time' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $cleanMobile = preg_replace('/[^0-9]/', '', $request->mobile);

        // Duplicate Lead Check
        $existingLead = Lead::where('mobile', 'like', "%{$cleanMobile}%")->first();
        $isDuplicate = false;
        $duplicateOfId = null;

        if ($existingLead) {
            $isDuplicate = true;
            $duplicateOfId = $existingLead->id;
        }

        // Default Website Source
        $source = LeadSource::firstOrCreate(
            ['code' => 'website'],
            ['name' => 'Website Free Counselling Form', 'icon' => 'bi-globe']
        );

        // Assign to first active counsellor or admin
        $counsellor = User::where('role', 'counsellor')->first() ?? User::where('role', 'admin')->first();

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
            'course_interest' => $request->course_interest,
            'preferred_counselling_date' => $request->preferred_counselling_date ?: Carbon::now()->addDays(1)->toDateString(),
            'preferred_counselling_time' => $request->preferred_counselling_time ?: '11:00 AM',
            'lead_source_id' => $source->id,
            'assigned_to_user_id' => $counsellor ? $counsellor->id : null,
            'status' => 'new_enquiry',
            'notes' => $request->notes ?: 'New enquiry submitted via Website Landing Page form.',
            'followup_date' => Carbon::now()->toDateString(),
            'followup_time' => '10:00:00',
            'followup_notes' => 'Call parent regarding free counselling slot confirmation.',
            'is_duplicate' => $isDuplicate,
            'duplicate_of_lead_id' => $duplicateOfId,
        ]);

        // Record Activity
        LeadActivity::create([
            'lead_id' => $lead->id,
            'type' => 'note',
            'title' => 'Web Enquiry Captured',
            'description' => "Enquiry received for '{$lead->course_interest}'. Preferred counselling date: " . ($lead->preferred_counselling_date ? $lead->preferred_counselling_date->format('d M Y') : 'Immediate') . ($isDuplicate ? ' (Duplicate phone number detected)' : ''),
        ]);

        // Automated WhatsApp Acknowledgement log
        CommunicationLog::create([
            'channel' => 'whatsapp',
            'recipient_type' => 'lead',
            'recipient_id' => $lead->id,
            'recipient_phone_or_email' => $cleanMobile,
            'template_name' => 'website_enquiry_acknowledgement',
            'message_content' => "Hello {$lead->parent_name}! Thank you for choosing Talent Gurukul India. We have received your request for a Free Brain Counselling Session ({$lead->course_interest}). Our senior brain counsellor will contact you shortly.",
            'status' => 'sent',
            'sent_by_user_id' => $counsellor ? $counsellor->id : null,
        ]);

        return redirect()->route('home')->with('success_modal', [
            'title' => 'Counselling Booking Received!',
            'message' => "Dear {$request->parent_name}, your Free Brain Counselling Session request for '{$request->course_interest}' has been registered successfully. Our counsellor will call you at {$cleanMobile}.",
            'lead_id' => $lead->id
        ]);
    }
}
