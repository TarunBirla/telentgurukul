<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadSource;
use App\Models\Lead;
use App\Models\Enrolment;
use App\Models\StudentPayment;
use App\Models\User;
use App\Models\Course;
use App\Models\Branch;
use App\Models\AuditLog;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Marketing Lead Source Performance
        $sources = LeadSource::withCount('leads')->get()->map(function($source) {
            $convertedCount = Lead::where('lead_source_id', $source->id)->where('status', 'admission_confirmed')->count();
            $conversionRate = $source->leads_count > 0 ? round(($convertedCount / $source->leads_count) * 100, 1) : 0;
            return [
                'name' => $source->name,
                'icon' => $source->icon,
                'total_leads' => $source->leads_count,
                'converted' => $convertedCount,
                'conversion_rate' => $conversionRate,
            ];
        });

        // 2. Counsellor Performance
        $counsellors = User::whereIn('role', ['counsellor', 'admin'])->get()->map(function($user) {
            $assignedCount = Lead::where('assigned_to_user_id', $user->id)->count();
            $counsellingCount = Lead::where('assigned_to_user_id', $user->id)
                ->whereIn('status', ['counselling_scheduled', 'counselling_completed', 'admission_confirmed'])
                ->count();
            $convertedCount = Lead::where('assigned_to_user_id', $user->id)->where('status', 'admission_confirmed')->count();
            $rate = $assignedCount > 0 ? round(($convertedCount / $assignedCount) * 100, 1) : 0;

            return [
                'name' => $user->name,
                'role' => $user->role,
                'assigned' => $assignedCount,
                'counselling_done' => $counsellingCount,
                'converted' => $convertedCount,
                'conversion_rate' => $rate,
            ];
        });

        // 3. Course wise revenue
        $courses = Course::with(['enrolments'])->get()->map(function($course) {
            $enrolled = $course->enrolments->count();
            $revenue = $course->enrolments->sum('paid_amount');
            $pending = $course->enrolments->sum('due_balance');

            return [
                'name' => $course->name,
                'category' => $course->category,
                'enrolments' => $enrolled,
                'revenue' => $revenue,
                'pending' => $pending,
            ];
        });

        $totalRevenue = StudentPayment::sum('amount');
        $totalAdmissions = Enrolment::count();

        return view('crm.reports.index', compact('sources', 'counsellors', 'courses', 'totalRevenue', 'totalAdmissions'));
    }

    public function settings()
    {
        $users = User::with('branch')->get();
        $branches = Branch::all();
        $auditLogs = AuditLog::with('user')->latest()->take(30)->get();

        return view('crm.settings.index', compact('users', 'branches', 'auditLogs'));
    }
}
