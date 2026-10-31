<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\Course;
use App\Models\Branch;
use App\Models\Enrolment;
use App\Models\StudentInvoice;
use App\Models\StudentPayment;
use App\Models\Attendance;
use App\Models\Assessment;
use App\Models\Certificate;
use App\Models\StudentDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['parent', 'branch', 'enrolments.course']);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->search) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('first_name', 'like', "%{$s}%")
                  ->orWhere('last_name', 'like', "%{$s}%")
                  ->orWhere('student_id_number', 'like', "%{$s}%")
                  ->orWhereHas('parent', function($pq) use ($s) {
                      $pq->where('father_name', 'like', "%{$s}%")
                         ->orWhere('mother_name', 'like', "%{$s}%")
                         ->orWhere('primary_mobile', 'like', "%{$s}%");
                  });
            });
        }

        $students = $query->latest()->paginate(15);
        $branches = Branch::all();
        $courses = Course::all();

        return view('crm.students.index', compact('students', 'branches', 'courses'));
    }

    public function parents()
    {
        $parents = ParentModel::with(['students.enrolments.course', 'invoices', 'payments'])->latest()->paginate(15);
        return view('crm.students.parents', compact('parents'));
    }

    public function create()
    {
        $branches = Branch::all();
        $courses = Course::all();
        $parents = ParentModel::all();
        return view('crm.students.create', compact('branches', 'courses', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'primary_mobile' => 'required|string|max:20',
            'course_id' => 'required|exists:courses,id',
        ]);

        $cleanMobile = preg_replace('/[^0-9]/', '', $request->primary_mobile);

        // Find or create parent
        $parent = ParentModel::where('primary_mobile', $cleanMobile)->first();
        if (!$parent) {
            $parent = ParentModel::create([
                'father_name' => $request->father_name ?: 'Parent of ' . $request->first_name,
                'mother_name' => $request->mother_name,
                'primary_mobile' => $cleanMobile,
                'whatsapp_number' => $request->whatsapp_number ?: $cleanMobile,
                'email' => $request->email,
                'city' => $request->city ?: 'Noida / NCR',
                'address' => $request->address,
            ]);
        }

        // Generate ID
        $nextNum = Student::count() + 1;
        $studentId = 'TG-' . date('Y') . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        $student = Student::create([
            'student_id_number' => $studentId,
            'parent_id' => $parent->id,
            'branch_id' => $request->branch_id ?: 1,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'dob' => $request->dob,
            'age' => $request->age,
            'gender' => $request->gender,
            'school_name' => $request->school_name,
            'current_class' => $request->current_class,
            'city' => $request->city ?: 'Noida / NCR',
            'admission_date' => $request->admission_date ?: Carbon::now()->toDateString(),
            'status' => 'active',
        ]);

        // Create Enrolment
        $course = Course::findOrFail($request->course_id);
        $discount = $request->discount_amount ?: 0;
        $finalFee = max(0, $course->course_fee - $discount);
        $enrolNumber = 'ENR-' . date('Y') . '-' . str_pad(Enrolment::count() + 1, 3, '0', STR_PAD_LEFT);

        $enrolment = Enrolment::create([
            'enrolment_number' => $enrolNumber,
            'student_id' => $student->id,
            'course_id' => $course->id,
            'branch_id' => $request->branch_id ?: 1,
            'admission_date' => Carbon::now()->toDateString(),
            'start_date' => $request->start_date ?: Carbon::now()->addDays(2)->toDateString(),
            'total_fee' => $course->course_fee,
            'discount_amount' => $discount,
            'final_payable' => $finalFee,
            'paid_amount' => 0,
            'due_balance' => $finalFee,
            'status' => 'active',
        ]);

        // Invoice
        StudentInvoice::create([
            'invoice_number' => 'INV-' . date('Y') . '-' . str_pad(StudentInvoice::count() + 1, 3, '0', STR_PAD_LEFT),
            'enrolment_id' => $enrolment->id,
            'student_id' => $student->id,
            'parent_id' => $parent->id,
            'title' => 'Course Fee - ' . $course->name,
            'total_amount' => $course->course_fee,
            'discount_amount' => $discount,
            'final_payable' => $finalFee,
            'balance_due' => $finalFee,
            'invoice_date' => Carbon::now()->toDateString(),
            'due_date' => Carbon::now()->addDays(7)->toDateString(),
            'status' => 'unpaid',
        ]);

        // Initial default document
        StudentDocument::create([
            'student_id' => $student->id,
            'title' => 'Student Admission Form (Verified)',
            'document_type' => 'registration_form',
            'is_verified' => true,
        ]);

        return redirect()->route('crm.students.show', $student->id)->with('success', "Student {$student->first_name} registered successfully!");
    }

    public function show($id)
    {
        $student = Student::with([
            'parent.students',
            'branch',
            'enrolments.course',
            'attendances.schedule',
            'invoices.payments',
            'payments',
            'assessments.trainer',
            'certificates.course',
            'documents'
        ])->findOrFail($id);

        $courses = Course::all();

        return view('crm.students.show', compact('student', 'courses'));
    }
}
