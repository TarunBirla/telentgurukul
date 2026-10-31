<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CoursePackage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount(['enrolments', 'batches'])->get();
        $packages = CoursePackage::all();
        return view('crm.courses.index', compact('courses', 'packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'course_fee' => 'required|numeric|min:0',
            'total_sessions' => 'required|numeric|min:1',
        ]);

        $course = Course::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(10, 99),
            'category' => $request->category ?: 'Brain Development',
            'description' => $request->description,
            'duration_days' => $request->duration_days ?: 30,
            'total_sessions' => $request->total_sessions,
            'session_minutes' => $request->session_minutes ?: 60,
            'course_fee' => $request->course_fee,
            'registration_fee' => $request->registration_fee ?: 1000,
            'max_batch_capacity' => $request->max_batch_capacity ?: 15,
            'has_certificate' => $request->has('has_certificate'),
            'has_assessment' => $request->has('has_assessment'),
            'is_active' => true,
        ]);

        return back()->with('success', 'Course "' . $course->name . '" created successfully.');
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'package_fee' => 'required|numeric|min:0',
        ]);

        CoursePackage::create([
            'name' => $request->name,
            'description' => $request->description,
            'included_course_ids' => $request->included_course_ids ?: [],
            'original_fee' => $request->original_fee ?: $request->package_fee,
            'package_fee' => $request->package_fee,
            'discount_amount' => max(0, ($request->original_fee ?: $request->package_fee) - $request->package_fee),
            'duration_days' => $request->duration_days ?: 60,
            'is_active' => true,
        ]);

        return back()->with('success', 'Course Package created successfully.');
    }
}
