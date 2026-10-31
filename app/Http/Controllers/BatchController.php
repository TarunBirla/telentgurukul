<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\BatchStudent;
use App\Models\ClassSchedule;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use App\Models\Branch;
use Carbon\Carbon;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with(['course', 'trainer', 'branch', 'batchStudents.student'])->latest()->get();
        $courses = Course::all();
        $trainers = User::whereIn('role', ['trainer', 'admin'])->get();
        $branches = Branch::all();
        $students = Student::where('status', 'active')->get();

        return view('crm.batches.index', compact('batches', 'courses', 'trainers', 'branches', 'students'));
    }

    public function show($id)
    {
        $batch = Batch::with([
            'course',
            'trainer',
            'branch',
            'batchStudents.student.attendances',
            'schedules.attendances'
        ])->findOrFail($id);

        $trainers = User::whereIn('role', ['trainer', 'admin'])->get();
        $allStudents = Student::where('status', 'active')->get();

        return view('crm.batches.show', compact('batch', 'trainers', 'allStudents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_name' => 'required|string|max:150',
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
        ]);

        $batchCode = 'BTH-' . strtoupper(substr(str_replace(' ', '', Course::find($request->course_id)->name), 0, 3)) . '-' . str_pad(Batch::count() + 1, 2, '0', STR_PAD_LEFT);

        $batch = Batch::create([
            'batch_code' => $batchCode,
            'batch_name' => $request->batch_name,
            'course_id' => $request->course_id,
            'trainer_id' => $request->trainer_id,
            'branch_id' => $request->branch_id ?: 1,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days_of_week' => $request->days_of_week ?: 'Mon,Wed,Fri',
            'class_time' => $request->class_time ?: '04:00 PM - 05:30 PM',
            'max_capacity' => $request->max_capacity ?: 15,
            'status' => 'running',
            'notes' => $request->notes,
        ]);

        return back()->with('success', "Batch {$batch->batch_code} ({$batch->batch_name}) created successfully!");
    }

    public function addStudent(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);
        $request->validate(['student_id' => 'required|exists:students,id']);

        $exists = BatchStudent::where('batch_id', $batch->id)->where('student_id', $request->student_id)->first();
        if ($exists) {
            return back()->with('error', 'Student is already assigned to this batch.');
        }

        BatchStudent::create([
            'batch_id' => $batch->id,
            'student_id' => $request->student_id,
            'joined_date' => Carbon::now()->toDateString(),
            'status' => 'active',
        ]);

        return back()->with('success', 'Student enrolled into batch successfully.');
    }

    public function scheduleClass(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $request->validate([
            'class_date' => 'required|date',
            'topic' => 'required|string|max:200',
        ]);

        $sessionNum = $batch->schedules()->count() + 1;

        ClassSchedule::create([
            'batch_id' => $batch->id,
            'trainer_id' => $request->trainer_id ?: $batch->trainer_id,
            'session_number' => $sessionNum,
            'topic' => $request->topic,
            'class_date' => $request->class_date,
            'start_time' => $request->start_time ?: '04:00 PM',
            'end_time' => $request->end_time ?: '05:30 PM',
            'status' => 'scheduled',
            'homework' => $request->homework,
        ]);

        return back()->with('success', "Session {$sessionNum} scheduled successfully.");
    }

    public function markAttendance(Request $request, $scheduleId)
    {
        $schedule = ClassSchedule::findOrFail($scheduleId);
        $attendances = $request->input('attendance', []); // [student_id => 'present'|'absent'|'late']
        $remarks = $request->input('remarks', []);

        foreach ($attendances as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'class_schedule_id' => $schedule->id,
                    'student_id' => $studentId,
                ],
                [
                    'batch_id' => $schedule->batch_id,
                    'attendance_date' => $schedule->class_date,
                    'status' => $status,
                    'remarks' => $remarks[$studentId] ?? null,
                ]
            );
        }

        $schedule->status = 'conducted';
        $schedule->save();

        return back()->with('success', 'Attendance marked successfully and saved for ' . count($attendances) . ' students.');
    }
}
