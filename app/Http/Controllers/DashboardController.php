<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Student;
use App\Models\Enrolment;
use App\Models\CounsellingAppointment;
use App\Models\ClassSchedule;
use App\Models\StudentInvoice;
use App\Models\StudentPayment;
use App\Models\Course;
use App\Models\LeadSource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // 1. Core Metrics
        $totalLeads = Lead::count();
        $newLeadsToday = Lead::whereDate('created_at', $today)->count();
        $followupsDueToday = Lead::whereDate('followup_date', '<=', $today)
            ->whereNotIn('status', ['admission_confirmed', 'lost_lead'])
            ->count();

        $counsellingScheduled = CounsellingAppointment::where('status', 'scheduled')->count();
        $admissionsCompleted = Enrolment::where('status', '!=', 'cancelled')->count();
        $activeStudents = Student::where('status', 'active')->count();

        // Fee calculations
        $totalFeesCollected = StudentPayment::sum('amount');
        $totalOutstanding = StudentInvoice::sum('balance_due');
        $studentsPendingFees = StudentInvoice::where('balance_due', '>', 0)->distinct('student_id')->count('student_id');

        $upcomingClassesCount = ClassSchedule::whereDate('class_date', '>=', $today)
            ->where('status', 'scheduled')
            ->count();

        // 2. Lead Sources Breakdown for Charts
        $leadSources = LeadSource::withCount('leads')->get();
        $sourceLabels = $leadSources->pluck('name')->toArray();
        $sourceCounts = $leadSources->pluck('leads_count')->toArray();

        // 3. Course wise Registrations
        $courses = Course::withCount('enrolments')->get();
        $courseLabels = $courses->pluck('name')->toArray();
        $courseCounts = $courses->pluck('enrolments_count')->toArray();

        // 4. Pipeline Stages Count
        $pipelineStages = [
            'new_enquiry' => Lead::where('status', 'new_enquiry')->count(),
            'contact_pending' => Lead::where('status', 'contact_pending')->count(),
            'contacted' => Lead::where('status', 'contacted')->count(),
            'interested' => Lead::where('status', 'interested')->count(),
            'counselling_scheduled' => Lead::where('status', 'counselling_scheduled')->count(),
            'counselling_completed' => Lead::where('status', 'counselling_completed')->count(),
            'followup_required' => Lead::where('status', 'followup_required')->count(),
            'admission_confirmed' => Lead::where('status', 'admission_confirmed')->count(),
            'lost_lead' => Lead::where('status', 'lost_lead')->count(),
        ];

        // 5. Recent Lists
        $recentLeads = Lead::with('source', 'assignedUser')->latest()->take(6)->get();
        
        $todayFollowups = Lead::whereDate('followup_date', '<=', $today)
            ->whereNotIn('status', ['admission_confirmed', 'lost_lead'])
            ->with('assignedUser')
            ->orderBy('followup_time', 'asc')
            ->take(6)
            ->get();

        $todayCounselling = CounsellingAppointment::whereDate('appointment_date', '>=', $today)
            ->where('status', 'scheduled')
            ->with('lead', 'counsellor')
            ->orderBy('appointment_date', 'asc')
            ->take(5)
            ->get();

        $upcomingClasses = ClassSchedule::whereDate('class_date', '>=', $today)
            ->with('batch.course', 'trainer')
            ->orderBy('class_date', 'asc')
            ->take(5)
            ->get();

        return view('crm.dashboard', compact(
            'totalLeads',
            'newLeadsToday',
            'followupsDueToday',
            'counsellingScheduled',
            'admissionsCompleted',
            'activeStudents',
            'totalFeesCollected',
            'totalOutstanding',
            'studentsPendingFees',
            'upcomingClassesCount',
            'sourceLabels',
            'sourceCounts',
            'courseLabels',
            'courseCounts',
            'pipelineStages',
            'recentLeads',
            'todayFollowups',
            'todayCounselling',
            'upcomingClasses'
        ));
    }
}
