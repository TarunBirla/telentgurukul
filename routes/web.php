<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CounsellingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ParentPortalController;

/*
|--------------------------------------------------------------------------
| Web Routes - Talent Gurukul India CRM & Portal
|--------------------------------------------------------------------------
*/

// 1. Frontend Landing Page
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::post('/enquiry', [FrontendController::class, 'submitEnquiry'])->name('enquiry.submit');

// 2. Server Installation & Database Setup Routes (Both GET and POST supported so 1 URL hit sets up everything!)
Route::get('/setup', [SetupController::class, 'index'])->name('setup.index');
Route::get('/install', [SetupController::class, 'index'])->name('setup.install');
Route::match(['get', 'post'], '/setup/run', [SetupController::class, 'run'])->name('setup.run');

// 3. Authentication & One-Click Role Switcher
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/login/as/{role}', [AuthController::class, 'loginAs'])->name('login.as');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// 4. CRM Backend Routes
Route::prefix('crm')->name('crm.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Leads & Enquiries
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/pipeline', [LeadController::class, 'pipeline'])->name('leads.pipeline');
    Route::get('/leads/followups', [LeadController::class, 'followups'])->name('leads.followups');
    Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/leads/{id}', [LeadController::class, 'show'])->name('leads.show');
    Route::post('/leads/{id}/status', [LeadController::class, 'updateStatus'])->name('leads.status');
    Route::post('/leads/{id}/activity', [LeadController::class, 'addActivity'])->name('leads.activity');
    Route::post('/leads/{id}/assign', [LeadController::class, 'assign'])->name('leads.assign');
    Route::post('/leads/{id}/convert', [LeadController::class, 'convertToStudent'])->name('leads.convert');

    // Counselling
    Route::get('/counselling', [CounsellingController::class, 'index'])->name('counselling.index');
    Route::post('/counselling', [CounsellingController::class, 'store'])->name('counselling.store');
    Route::post('/counselling/{id}/outcome', [CounsellingController::class, 'recordOutcome'])->name('counselling.outcome');

    // Students & Parents
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/parents', [StudentController::class, 'parents'])->name('students.parents');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');

    // Courses & Programs
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::post('/courses/packages', [CourseController::class, 'storePackage'])->name('courses.package.store');

    // Batches & Attendance
    Route::get('/batches', [BatchController::class, 'index'])->name('batches.index');
    Route::get('/batches/{id}', [BatchController::class, 'show'])->name('batches.show');
    Route::post('/batches', [BatchController::class, 'store'])->name('batches.store');
    Route::post('/batches/{id}/students', [BatchController::class, 'addStudent'])->name('batches.student.add');
    Route::post('/batches/{id}/schedule', [BatchController::class, 'scheduleClass'])->name('batches.schedule');
    Route::post('/batches/schedule/{id}/attendance', [BatchController::class, 'markAttendance'])->name('batches.attendance');

    // Fees & Accounts
    Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');
    Route::get('/fees/payments', [FeeController::class, 'payments'])->name('fees.payments');
    Route::post('/fees/payments', [FeeController::class, 'storePayment'])->name('fees.payment.store');
    Route::get('/fees/receipt/{id}', [FeeController::class, 'receipt'])->name('fees.receipt');

    // Progress & Certificates
    Route::get('/progress', [AssessmentController::class, 'index'])->name('progress.index');
    Route::post('/progress/assessments', [AssessmentController::class, 'store'])->name('progress.assessment.store');
    Route::post('/progress/certificates', [AssessmentController::class, 'generateCertificate'])->name('progress.certificate.store');
    Route::get('/progress/certificate/{id}', [AssessmentController::class, 'showCertificate'])->name('progress.certificate.show');
    Route::get('/progress/report/{studentId}', [AssessmentController::class, 'showReport'])->name('progress.report');

    // Communication
    Route::get('/communication', [CommunicationController::class, 'index'])->name('communication.index');
    Route::post('/communication/send', [CommunicationController::class, 'send'])->name('communication.send');

    // Marketing & Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/settings', [ReportController::class, 'settings'])->name('settings.index');
});

// 5. Parent Portal
Route::prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentPortalController::class, 'dashboard'])->name('dashboard');
    Route::post('/feedback', [ParentPortalController::class, 'submitFeedback'])->name('feedback.submit');
});
