<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\FeedbackTicket;
use Illuminate\Support\Facades\Auth;

class ParentPortalController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Find parent record
        $parent = null;
        if ($user) {
            $parent = ParentModel::where('user_id', $user->id)
                ->orWhere('primary_mobile', preg_replace('/[^0-9]/', '', $user->phone ?? ''))
                ->orWhere('email', $user->email)
                ->first();
        }

        // Fallback for demonstration
        if (!$parent) {
            $parent = ParentModel::first();
        }

        $students = $parent ? $parent->students()->with([
            'enrolments.course',
            'attendances.schedule',
            'invoices.payments',
            'assessments',
            'certificates.course'
        ])->get() : collect();

        $feedbackTickets = $parent ? $parent->feedbackTickets()->latest()->get() : collect();

        return view('parent.dashboard', compact('parent', 'students', 'feedbackTickets'));
    }

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:150',
            'description' => 'required|string',
        ]);

        $user = Auth::user();
        $parent = ParentModel::where('user_id', $user->id)->first() ?? ParentModel::first();

        FeedbackTicket::create([
            'ticket_number' => 'TCK-' . date('Y') . '-' . str_pad(FeedbackTicket::count() + 1, 4, '0', STR_PAD_LEFT),
            'parent_id' => $parent ? $parent->id : null,
            'student_id' => $request->student_id,
            'category' => $request->category ?: 'General',
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => 'medium',
            'status' => 'open',
        ]);

        return back()->with('success', 'Your feedback / request has been submitted to Talent Gurukul management!');
    }
}
