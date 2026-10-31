<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Certificate;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrolment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with(['student.parent', 'trainer'])->latest()->paginate(15);
        $certificates = Certificate::with(['student', 'course'])->latest()->paginate(15);
        $students = Student::where('status', 'active')->get();
        $courses = Course::all();

        return view('crm.progress.index', compact('assessments', 'certificates', 'students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'assessment_type' => 'required|in:before,mid,after',
            'assessment_date' => 'required|date',
            'memory_score' => 'required|numeric|min:0|max:100',
            'concentration_score' => 'required|numeric|min:0|max:100',
        ]);

        $student = Student::findOrFail($request->student_id);
        $enrolment = $student->enrolments()->latest()->first();

        Assessment::create([
            'student_id' => $student->id,
            'enrolment_id' => $enrolment ? $enrolment->id : null,
            'assessment_type' => $request->assessment_type,
            'assessment_date' => $request->assessment_date,
            'memory_score' => $request->memory_score,
            'concentration_score' => $request->concentration_score,
            'reading_speed_wpm' => $request->reading_speed_wpm ?: 120,
            'recall_accuracy_pct' => $request->recall_accuracy_pct ?: 60,
            'confidence_score' => $request->confidence_score ?: 50,
            'trainer_id' => Auth::id(),
            'observations' => $request->observations,
            'parent_feedback' => $request->parent_feedback,
        ]);

        return back()->with('success', ucfirst($request->assessment_type) . ' Assessment recorded successfully for ' . $student->first_name);
    }

    public function generateCertificate(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'issue_date' => 'required|date',
        ]);

        $certNum = 'TG-CERT-' . date('Y') . '-' . str_pad(Certificate::count() + 1, 4, '0', STR_PAD_LEFT);
        $student = Student::findOrFail($request->student_id);
        $enrolment = $student->enrolments()->where('course_id', $request->course_id)->latest()->first();

        $cert = Certificate::create([
            'certificate_number' => $certNum,
            'student_id' => $student->id,
            'enrolment_id' => $enrolment ? $enrolment->id : null,
            'course_id' => $request->course_id,
            'issue_date' => $request->issue_date,
            'grade' => $request->grade ?: 'A+ with Distinction',
            'authorized_by' => $request->authorized_by ?: 'Dr. Sameer Verma (Director)',
            'status' => 'issued',
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', "Certificate {$certNum} generated successfully for {$student->first_name}!");
    }

    public function showCertificate($id)
    {
        $certificate = Certificate::with(['student.parent', 'course'])->findOrFail($id);
        return view('crm.progress.certificate', compact('certificate'));
    }

    public function showReport($studentId)
    {
        $student = Student::with(['parent', 'enrolments.course', 'assessments', 'attendances'])->findOrFail($studentId);
        $before = $student->assessments->where('assessment_type', 'before')->first();
        $after = $student->assessments->where('assessment_type', 'after')->first();

        return view('crm.progress.report', compact('student', 'before', 'after'));
    }
}
