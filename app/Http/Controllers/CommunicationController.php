<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunicationLog;
use App\Models\Lead;
use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
    public function index(Request $request)
    {
        $query = CommunicationLog::with('sender');

        if ($request->channel) {
            $query->where('channel', $request->channel);
        }

        $logs = $query->latest()->paginate(20);
        $leads = Lead::all();
        $parents = ParentModel::all();

        $templates = [
            'enquiry_acknowledgement' => [
                'name' => 'Enquiry Acknowledgement',
                'body' => 'Dear [ParentName], thank you for contacting Talent Gurukul India! We have received your query for [CourseName]. Our expert counsellor will reach out shortly to guide you. Call us anytime at +91 98765 43210.',
            ],
            'counselling_reminder' => [
                'name' => 'Counselling Appointment Reminder',
                'body' => 'Dear [ParentName], gentle reminder for your Free Brain Assessment & Counselling session for [StudentName] tomorrow at [Time] at Talent Gurukul centre. See you!',
            ],
            'payment_receipt' => [
                'name' => 'Payment Receipt Confirmation',
                'body' => 'Dear [ParentName], payment of [Amount] has been received for [StudentName] (Receipt: [ReceiptNo]). Thank you for partnering with Talent Gurukul in your child development journey!',
            ],
            'fee_reminder' => [
                'name' => 'Fee Installment Reminder',
                'body' => 'Dear [ParentName], this is a friendly reminder that an installment of [BalanceDue] for [StudentName] course is due on [DueDate]. Kindly contact accounts for online UPI payment.',
            ],
            'class_reminder' => [
                'name' => 'Upcoming Class Reminder',
                'body' => 'Dear [ParentName], [StudentName] next brain training class is scheduled for [Date] at [Time]. Please ensure child carries visual practice kit. Talent Gurukul.',
            ],
            'course_completion' => [
                'name' => 'Course Completion & Congratulations',
                'body' => 'Congratulations! [StudentName] has successfully completed the [CourseName] program at Talent Gurukul India. Certificate and final progress report are now ready in the parent portal!',
            ]
        ];

        return view('crm.communication.index', compact('logs', 'leads', 'parents', 'templates'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'channel' => 'required|in:whatsapp,sms,email',
            'recipient_phone_or_email' => 'required',
            'message_content' => 'required',
        ]);

        CommunicationLog::create([
            'channel' => $request->channel,
            'recipient_type' => $request->recipient_type ?: 'lead',
            'recipient_id' => $request->recipient_id,
            'recipient_phone_or_email' => $request->recipient_phone_or_email,
            'template_name' => $request->template_name ?: 'custom_message',
            'message_content' => $request->message_content,
            'status' => 'sent',
            'sent_by_user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Message dispatched successfully via ' . ucfirst($request->channel) . '!');
    }
}
