<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Branch;
use App\Models\LeadSource;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\CounsellingAppointment;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Course;
use App\Models\CoursePackage;
use App\Models\Enrolment;
use App\Models\Batch;
use App\Models\BatchStudent;
use App\Models\ClassSchedule;
use App\Models\Attendance;
use App\Models\StudentInvoice;
use App\Models\StudentPayment;
use App\Models\Assessment;
use App\Models\Certificate;
use App\Models\StudentDocument;
use App\Models\CommunicationLog;
use App\Models\FeedbackTicket;
use App\Models\AuditLog;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Branches
        $branch1 = Branch::create([
            'name' => 'Talent Gurukul - Corporate Head Office',
            'code' => 'TG-HQ-01',
            'phone' => '+91 98765 43210',
            'email' => 'info@talentgurukulindia.com',
            'city' => 'Noida / NCR',
            'address' => 'Sector 62, Institutional Area, Noida, UP - 201309',
            'is_active' => true,
        ]);

        $branch2 = Branch::create([
            'name' => 'Talent Gurukul - South Delhi Learning Centre',
            'code' => 'TG-DEL-02',
            'phone' => '+91 98765 43211',
            'email' => 'delhi@talentgurukulindia.com',
            'city' => 'New Delhi',
            'address' => 'Green Park Main Market, New Delhi - 110016',
            'is_active' => true,
        ]);

        $branch3 = Branch::create([
            'name' => 'Talent Gurukul - Lucknow Training Hub',
            'code' => 'TG-LKO-03',
            'phone' => '+91 98765 43212',
            'email' => 'lucknow@talentgurukulindia.com',
            'city' => 'Lucknow',
            'address' => 'Gomti Nagar, Lucknow, UP - 226010',
            'is_active' => true,
        ]);

        // 2. Users (Role based)
        $admin = User::create([
            'name' => 'Dr. Sameer Verma (Director)',
            'email' => 'admin@talentgurukul.com',
            'phone' => '+91 98111 22233',
            'role' => 'admin',
            'branch_id' => $branch1->id,
            'password' => Hash::make('password'),
        ]);

        $counsellor = User::create([
            'name' => 'Pooja Kashyap (Sr. Brain Counsellor)',
            'email' => 'counsellor@talentgurukul.com',
            'phone' => '+91 98222 33344',
            'role' => 'counsellor',
            'branch_id' => $branch1->id,
            'password' => Hash::make('password'),
        ]);

        $counsellor2 = User::create([
            'name' => 'Rohan Mehta (Admissions Counsellor)',
            'email' => 'rohan@talentgurukul.com',
            'phone' => '+91 98333 44455',
            'role' => 'counsellor',
            'branch_id' => $branch2->id,
            'password' => Hash::make('password'),
        ]);

        $admissionsExec = User::create([
            'name' => 'Neha Sharma (Admissions Executive)',
            'email' => 'admissions@talentgurukul.com',
            'phone' => '+91 98444 55566',
            'role' => 'admission_executive',
            'branch_id' => $branch1->id,
            'password' => Hash::make('password'),
        ]);

        $accountant = User::create([
            'name' => 'Vikas Gupta (Accounts Head)',
            'email' => 'accounts@talentgurukul.com',
            'phone' => '+91 98555 66677',
            'role' => 'accountant',
            'branch_id' => $branch1->id,
            'password' => Hash::make('password'),
        ]);

        $trainer = User::create([
            'name' => 'Master Ankit Saxena (Lead Brain Trainer)',
            'email' => 'trainer@talentgurukul.com',
            'phone' => '+91 98666 77788',
            'role' => 'trainer',
            'branch_id' => $branch1->id,
            'password' => Hash::make('password'),
        ]);

        $parentUser = User::create([
            'name' => 'Rajesh Sharma',
            'email' => 'parent@gmail.com',
            'phone' => '+91 99887 76655',
            'role' => 'parent',
            'branch_id' => $branch1->id,
            'password' => Hash::make('password'),
        ]);

        // 3. Lead Sources
        $sourceWeb = LeadSource::create(['name' => 'Website Free Counselling Form', 'code' => 'website', 'icon' => 'bi-globe']);
        $sourceInsta = LeadSource::create(['name' => 'Instagram Ads', 'code' => 'instagram', 'icon' => 'bi-instagram']);
        $sourceFb = LeadSource::create(['name' => 'Facebook Ads', 'code' => 'facebook', 'icon' => 'bi-facebook']);
        $sourceGoogle = LeadSource::create(['name' => 'Google Search / Ads', 'code' => 'google', 'icon' => 'bi-google']);
        $sourceSeminar = LeadSource::create(['name' => 'School Seminar & Workshop', 'code' => 'seminar', 'icon' => 'bi-easel']);
        $sourceReferral = LeadSource::create(['name' => 'Parent Referral', 'code' => 'referral', 'icon' => 'bi-people']);
        $sourceWhatsApp = LeadSource::create(['name' => 'WhatsApp Direct Enquiries', 'code' => 'whatsapp', 'icon' => 'bi-whatsapp']);
        $sourceWalkin = LeadSource::create(['name' => 'Centre Walk-in', 'code' => 'walkin', 'icon' => 'bi-geo-alt']);

        // 4. Courses
        $c1 = Course::create([
            'name' => 'Photographic Memory Training',
            'slug' => 'photographic-memory-training',
            'category' => 'Memory Enhancement',
            'description' => 'Train children to capture textbook pages, complex diagrams, and foreign vocabulary like photographs using right brain visualization techniques.',
            'duration_days' => 45,
            'total_sessions' => 15,
            'session_minutes' => 60,
            'course_fee' => 15000.00,
            'registration_fee' => 1000.00,
            'max_batch_capacity' => 15,
            'has_certificate' => true,
            'has_assessment' => true,
            'is_active' => true,
        ]);

        $c2 = Course::create([
            'name' => 'Midbrain Activation Program',
            'slug' => 'midbrain-activation',
            'category' => 'Brain Development',
            'description' => 'Bridge left and right hemispheres of the brain to unlock hidden cognitive power, intuition, blindfold sensory recognition, and peak focus.',
            'duration_days' => 60,
            'total_sessions' => 20,
            'session_minutes' => 90,
            'course_fee' => 18000.00,
            'registration_fee' => 1500.00,
            'max_batch_capacity' => 12,
            'has_certificate' => true,
            'has_assessment' => true,
            'is_active' => true,
        ]);

        $c3 = Course::create([
            'name' => 'DMIT & Brain Profiling Counselling',
            'slug' => 'dmit-counselling',
            'category' => 'Counselling & Profiling',
            'description' => 'Scientific Dermatoglyphics Multiple Intelligence Test and in-depth psychological counselling to discover innate talents, learning styles, and brain dominance.',
            'duration_days' => 10,
            'total_sessions' => 3,
            'session_minutes' => 60,
            'course_fee' => 12000.00,
            'registration_fee' => 500.00,
            'max_batch_capacity' => 5,
            'has_certificate' => true,
            'has_assessment' => true,
            'is_active' => true,
        ]);

        $c4 = Course::create([
            'name' => 'NLP & Mnemonics for Kids',
            'slug' => 'nlp-mnemonics',
            'category' => 'Neuro-Linguistic',
            'description' => 'Neuro-Linguistic Programming exercises combined with ancient Peg & Link mnemonic systems for exam stress elimination and effortless memorization.',
            'duration_days' => 30,
            'total_sessions' => 12,
            'session_minutes' => 60,
            'course_fee' => 14000.00,
            'registration_fee' => 1000.00,
            'max_batch_capacity' => 15,
            'has_certificate' => true,
            'has_assessment' => true,
            'is_active' => true,
        ]);

        $c5 = Course::create([
            'name' => 'Speed Reading & Quantum Comprehension',
            'slug' => 'speed-reading',
            'category' => 'Academic Accelerator',
            'description' => 'Expand eye span and eliminate sub-vocalization to read books 3x to 5x faster with 90%+ comprehension retention.',
            'duration_days' => 30,
            'total_sessions' => 10,
            'session_minutes' => 60,
            'course_fee' => 10000.00,
            'registration_fee' => 500.00,
            'max_batch_capacity' => 15,
            'has_certificate' => true,
            'has_assessment' => true,
            'is_active' => true,
        ]);

        $c6 = Course::create([
            'name' => 'Vedic Maths & Lightning Calculations',
            'slug' => 'vedic-maths',
            'category' => 'Mathematical Skills',
            'description' => 'Master 16 Vedic Sutras to perform mental calculations faster than a calculator without pencil and paper.',
            'duration_days' => 45,
            'total_sessions' => 16,
            'session_minutes' => 60,
            'course_fee' => 9000.00,
            'registration_fee' => 500.00,
            'max_batch_capacity' => 15,
            'has_certificate' => true,
            'has_assessment' => true,
            'is_active' => true,
        ]);

        // Course Packages
        CoursePackage::create([
            'name' => 'Complete Super Brain Development Package',
            'description' => 'All-inclusive 3-program journey: DMIT Profiling + Midbrain Activation + Photographic Memory Training.',
            'included_course_ids' => [$c1->id, $c2->id, $c3->id],
            'original_fee' => 45000.00,
            'package_fee' => 38000.00,
            'discount_amount' => 7000.00,
            'duration_days' => 90,
            'is_active' => true,
        ]);

        CoursePackage::create([
            'name' => 'Academic Accelerator Bundle',
            'description' => 'Photographic Memory + NLP Mnemonics + Vedic Maths for high school and competitive exam aspirants.',
            'included_course_ids' => [$c1->id, $c4->id, $c6->id],
            'original_fee' => 38000.00,
            'package_fee' => 32000.00,
            'discount_amount' => 6000.00,
            'duration_days' => 60,
            'is_active' => true,
        ]);

        // 5. Parents and Students (Demonstrating Multiple Children under 1 parent!)
        $parent1 = ParentModel::create([
            'user_id' => $parentUser->id,
            'father_name' => 'Rajesh Sharma',
            'mother_name' => 'Sunita Sharma',
            'primary_mobile' => '9988776655',
            'whatsapp_number' => '9988776655',
            'email' => 'parent@gmail.com',
            'emergency_contact' => '+91 99887 76656',
            'address' => 'Flat 402, Lotus Boulevard, Sector 100',
            'city' => 'Noida',
            'state' => 'Uttar Pradesh',
            'communication_preference' => 'whatsapp',
            'notes' => 'Very engaged parents, keen on memory improvement and concentration for their children.',
        ]);

        // Child 1
        $student1 = Student::create([
            'student_id_number' => 'TG-2024-001',
            'parent_id' => $parent1->id,
            'branch_id' => $branch1->id,
            'first_name' => 'Aarav',
            'last_name' => 'Sharma',
            'dob' => '2014-06-15',
            'age' => 10,
            'gender' => 'Male',
            'school_name' => 'Delhi Public School, Noida',
            'current_class' => '5th Grade',
            'city' => 'Noida',
            'blood_group' => 'B+',
            'admission_date' => Carbon::now()->subDays(45)->toDateString(),
            'status' => 'active',
        ]);

        // Child 2 (Under same parent account!)
        $student2 = Student::create([
            'student_id_number' => 'TG-2024-002',
            'parent_id' => $parent1->id,
            'branch_id' => $branch1->id,
            'first_name' => 'Ananya',
            'last_name' => 'Sharma',
            'dob' => '2016-11-20',
            'age' => 8,
            'gender' => 'Female',
            'school_name' => 'Delhi Public School, Noida',
            'current_class' => '3rd Grade',
            'city' => 'Noida',
            'blood_group' => 'O+',
            'admission_date' => Carbon::now()->subDays(30)->toDateString(),
            'status' => 'active',
        ]);

        // Parent 2
        $parent2 = ParentModel::create([
            'father_name' => 'Manoj Deshmukh',
            'mother_name' => 'Kavita Deshmukh',
            'primary_mobile' => '9871122334',
            'whatsapp_number' => '9871122334',
            'email' => 'manoj.deshmukh@gmail.com',
            'emergency_contact' => '+91 98711 22335',
            'address' => 'B-12, Defence Colony',
            'city' => 'New Delhi',
            'state' => 'Delhi',
            'communication_preference' => 'whatsapp',
        ]);

        $student3 = Student::create([
            'student_id_number' => 'TG-2024-003',
            'parent_id' => $parent2->id,
            'branch_id' => $branch2->id,
            'first_name' => 'Reyansh',
            'last_name' => 'Deshmukh',
            'dob' => '2013-03-10',
            'age' => 11,
            'gender' => 'Male',
            'school_name' => 'Modern School, Barakhamba',
            'current_class' => '6th Grade',
            'city' => 'New Delhi',
            'blood_group' => 'A+',
            'admission_date' => Carbon::now()->subDays(60)->toDateString(),
            'status' => 'active',
        ]);

        // Parent 3
        $parent3 = ParentModel::create([
            'father_name' => 'Dr. Alok Srivastava',
            'mother_name' => 'Dr. Ritu Srivastava',
            'primary_mobile' => '9415566778',
            'whatsapp_number' => '9415566778',
            'email' => 'alok.sri@yahoo.co.in',
            'emergency_contact' => '+91 94155 66779',
            'address' => 'House 55, Hazratganj',
            'city' => 'Lucknow',
            'state' => 'Uttar Pradesh',
            'communication_preference' => 'whatsapp',
        ]);

        $student4 = Student::create([
            'student_id_number' => 'TG-2024-004',
            'parent_id' => $parent3->id,
            'branch_id' => $branch3->id,
            'first_name' => 'Aditya',
            'last_name' => 'Srivastava',
            'dob' => '2012-08-25',
            'age' => 12,
            'gender' => 'Male',
            'school_name' => 'La Martiniere College, Lucknow',
            'current_class' => '7th Grade',
            'city' => 'Lucknow',
            'blood_group' => 'AB+',
            'admission_date' => Carbon::now()->subDays(90)->toDateString(),
            'status' => 'completed',
        ]);

        // 6. Enrolments
        $enrol1 = Enrolment::create([
            'enrolment_number' => 'ENR-2024-001',
            'student_id' => $student1->id,
            'course_id' => $c1->id,
            'branch_id' => $branch1->id,
            'counsellor_id' => $counsellor->id,
            'trainer_id' => $trainer->id,
            'admission_date' => Carbon::now()->subDays(45)->toDateString(),
            'start_date' => Carbon::now()->subDays(40)->toDateString(),
            'end_date' => Carbon::now()->addDays(5)->toDateString(),
            'total_fee' => 15000.00,
            'discount_amount' => 1500.00,
            'final_payable' => 13500.00,
            'paid_amount' => 13500.00,
            'due_balance' => 0.00,
            'status' => 'active',
            'remarks' => 'Enrolled with 10% sibling concession.',
        ]);

        $enrol2 = Enrolment::create([
            'enrolment_number' => 'ENR-2024-002',
            'student_id' => $student2->id,
            'course_id' => $c2->id,
            'branch_id' => $branch1->id,
            'counsellor_id' => $counsellor->id,
            'trainer_id' => $trainer->id,
            'admission_date' => Carbon::now()->subDays(30)->toDateString(),
            'start_date' => Carbon::now()->subDays(25)->toDateString(),
            'end_date' => Carbon::now()->addDays(35)->toDateString(),
            'total_fee' => 18000.00,
            'discount_amount' => 2000.00,
            'final_payable' => 16000.00,
            'paid_amount' => 10000.00,
            'due_balance' => 6000.00,
            'status' => 'active',
            'remarks' => 'Installment plan: ₹10,000 paid at admission, ₹6,000 balance next week.',
        ]);

        $enrol3 = Enrolment::create([
            'enrolment_number' => 'ENR-2024-003',
            'student_id' => $student3->id,
            'course_id' => $c4->id,
            'branch_id' => $branch2->id,
            'counsellor_id' => $counsellor2->id,
            'trainer_id' => $trainer->id,
            'admission_date' => Carbon::now()->subDays(60)->toDateString(),
            'start_date' => Carbon::now()->subDays(55)->toDateString(),
            'end_date' => Carbon::now()->subDays(5)->toDateString(),
            'total_fee' => 14000.00,
            'discount_amount' => 0.00,
            'final_payable' => 14000.00,
            'paid_amount' => 14000.00,
            'due_balance' => 0.00,
            'status' => 'completed',
        ]);

        $enrol4 = Enrolment::create([
            'enrolment_number' => 'ENR-2024-004',
            'student_id' => $student4->id,
            'course_id' => $c1->id,
            'branch_id' => $branch3->id,
            'counsellor_id' => $counsellor->id,
            'trainer_id' => $trainer->id,
            'admission_date' => Carbon::now()->subDays(90)->toDateString(),
            'start_date' => Carbon::now()->subDays(85)->toDateString(),
            'end_date' => Carbon::now()->subDays(40)->toDateString(),
            'total_fee' => 15000.00,
            'discount_amount' => 1000.00,
            'final_payable' => 14000.00,
            'paid_amount' => 14000.00,
            'due_balance' => 0.00,
            'status' => 'completed',
        ]);

        // 7. Batches
        $b1 = Batch::create([
            'batch_code' => 'BTH-MEM-01',
            'batch_name' => 'Photographic Memory - Champions Batch',
            'course_id' => $c1->id,
            'trainer_id' => $trainer->id,
            'branch_id' => $branch1->id,
            'start_date' => Carbon::now()->subDays(40)->toDateString(),
            'end_date' => Carbon::now()->addDays(5)->toDateString(),
            'days_of_week' => 'Mon,Wed,Fri',
            'class_time' => '04:00 PM - 05:00 PM',
            'max_capacity' => 12,
            'status' => 'running',
            'notes' => 'Students showing tremendous photographic capture improvement.',
        ]);

        $b2 = Batch::create([
            'batch_code' => 'BTH-MID-02',
            'batch_name' => 'Midbrain Activation - Junior Explorers',
            'course_id' => $c2->id,
            'trainer_id' => $trainer->id,
            'branch_id' => $branch1->id,
            'start_date' => Carbon::now()->subDays(25)->toDateString(),
            'end_date' => Carbon::now()->addDays(35)->toDateString(),
            'days_of_week' => 'Tue,Thu,Sat',
            'class_time' => '05:30 PM - 07:00 PM',
            'max_capacity' => 10,
            'status' => 'running',
            'notes' => 'Sensory exercises and blindfold color reading module active.',
        ]);

        // Batch Students
        BatchStudent::create(['batch_id' => $b1->id, 'student_id' => $student1->id, 'enrolment_id' => $enrol1->id, 'joined_date' => Carbon::now()->subDays(40)->toDateString(), 'status' => 'active']);
        BatchStudent::create(['batch_id' => $b2->id, 'student_id' => $student2->id, 'enrolment_id' => $enrol2->id, 'joined_date' => Carbon::now()->subDays(25)->toDateString(), 'status' => 'active']);

        // Class Schedules & Attendances for Batch 1
        for ($i = 1; $i <= 10; $i++) {
            $classDate = Carbon::now()->subDays(40 - ($i * 3));
            $sched = ClassSchedule::create([
                'batch_id' => $b1->id,
                'trainer_id' => $trainer->id,
                'session_number' => $i,
                'topic' => 'Session ' . $i . ': Right Brain Imaging & Memory Anchor Techniques',
                'class_date' => $classDate->toDateString(),
                'start_time' => '04:00 PM',
                'end_time' => '05:00 PM',
                'status' => 'conducted',
                'homework' => 'Practice 10-minute visual retention chart before sleep.',
            ]);

            Attendance::create([
                'class_schedule_id' => $sched->id,
                'batch_id' => $b1->id,
                'student_id' => $student1->id,
                'attendance_date' => $classDate->toDateString(),
                'status' => ($i == 4) ? 'absent' : 'present',
                'remarks' => ($i == 4) ? 'Informed leave due to school sports day' : 'Participated enthusiastically',
            ]);
        }

        // Upcoming schedule for Batch 1
        ClassSchedule::create([
            'batch_id' => $b1->id,
            'trainer_id' => $trainer->id,
            'session_number' => 11,
            'topic' => 'Session 11: Speed Memory Recall & Textbook Page Snapping',
            'class_date' => Carbon::now()->addDays(2)->toDateString(),
            'start_time' => '04:00 PM',
            'end_time' => '05:00 PM',
            'status' => 'scheduled',
            'homework' => 'Bring history chapter for live demonstration test.',
        ]);

        // 8. Invoices and Payments
        $inv1 = StudentInvoice::create([
            'invoice_number' => 'INV-2024-001',
            'enrolment_id' => $enrol1->id,
            'student_id' => $student1->id,
            'parent_id' => $parent1->id,
            'title' => 'Course Fee - Photographic Memory Training',
            'total_amount' => 15000.00,
            'discount_amount' => 1500.00,
            'final_payable' => 13500.00,
            'paid_amount' => 13500.00,
            'balance_due' => 0.00,
            'invoice_date' => Carbon::now()->subDays(45)->toDateString(),
            'due_date' => Carbon::now()->subDays(40)->toDateString(),
            'status' => 'paid',
            'notes' => 'Full fee paid at admission.',
        ]);

        StudentPayment::create([
            'receipt_number' => 'RCP-2024-001',
            'student_invoice_id' => $inv1->id,
            'enrolment_id' => $enrol1->id,
            'student_id' => $student1->id,
            'parent_id' => $parent1->id,
            'amount' => 13500.00,
            'payment_date' => Carbon::now()->subDays(45)->toDateString(),
            'payment_method' => 'upi',
            'transaction_reference' => 'UPI/412356789012/GPay',
            'collected_by_user_id' => $accountant->id,
            'notes' => 'Received via Google Pay QR.',
        ]);

        // Invoice 2 with Pending Installment!
        $inv2 = StudentInvoice::create([
            'invoice_number' => 'INV-2024-002',
            'enrolment_id' => $enrol2->id,
            'student_id' => $student2->id,
            'parent_id' => $parent1->id,
            'title' => 'Course Fee - Midbrain Activation Program',
            'total_amount' => 18000.00,
            'discount_amount' => 2000.00,
            'final_payable' => 16000.00,
            'paid_amount' => 10000.00,
            'balance_due' => 6000.00,
            'invoice_date' => Carbon::now()->subDays(30)->toDateString(),
            'due_date' => Carbon::now()->addDays(5)->toDateString(),
            'status' => 'partially_paid',
            'notes' => 'Installment 1 of 2 completed. Balance ₹6,000 due shortly.',
        ]);

        StudentPayment::create([
            'receipt_number' => 'RCP-2024-002',
            'student_invoice_id' => $inv2->id,
            'enrolment_id' => $enrol2->id,
            'student_id' => $student2->id,
            'parent_id' => $parent1->id,
            'amount' => 10000.00,
            'payment_date' => Carbon::now()->subDays(30)->toDateString(),
            'payment_method' => 'bank_transfer',
            'transaction_reference' => 'NEFT/HDFC000123/Rajesh',
            'collected_by_user_id' => $accountant->id,
            'notes' => 'First installment received.',
        ]);

        // 9. Assessments (Before and After Progress demonstration!)
        Assessment::create([
            'student_id' => $student1->id,
            'enrolment_id' => $enrol1->id,
            'assessment_type' => 'before',
            'assessment_date' => Carbon::now()->subDays(38)->toDateString(),
            'memory_score' => 48,
            'concentration_score' => 42,
            'reading_speed_wpm' => 110,
            'recall_accuracy_pct' => 50,
            'confidence_score' => 55,
            'trainer_id' => $trainer->id,
            'observations' => 'Baseline test: Aarav struggled to retain a 15-word random list after 5 minutes. Distracted easily while reading.',
            'parent_feedback' => 'Parent concerned that child forgets exam formulas and takes 2 hours for 1 chapter.',
        ]);

        Assessment::create([
            'student_id' => $student1->id,
            'enrolment_id' => $enrol1->id,
            'assessment_type' => 'after',
            'assessment_date' => Carbon::now()->subDays(2)->toDateString(),
            'memory_score' => 92,
            'concentration_score' => 88,
            'reading_speed_wpm' => 310,
            'recall_accuracy_pct' => 94,
            'confidence_score' => 90,
            'trainer_id' => $trainer->id,
            'observations' => 'Remarkable transformation: Aarav memorized 40 random objects in forward and reverse order using peg system in under 4 minutes. Speed reading increased 3x.',
            'parent_feedback' => 'Parents are delighted with Aarav school test grades. Now studying happily without stress.',
        ]);

        // 10. Certificates
        Certificate::create([
            'certificate_number' => 'TG-CERT-2024-001',
            'student_id' => $student4->id,
            'enrolment_id' => $enrol4->id,
            'course_id' => $c1->id,
            'issue_date' => Carbon::now()->subDays(35)->toDateString(),
            'grade' => 'A+ with Distinction',
            'authorized_by' => 'Dr. Sameer Verma (Director)',
            'status' => 'issued',
            'remarks' => 'Completed all 15 sessions and passed final photographic memory assessment with 96% score.',
        ]);

        // 11. Documents
        StudentDocument::create([
            'student_id' => $student1->id,
            'title' => 'Admission Registration Form Signed',
            'document_type' => 'registration_form',
            'file_path' => 'documents/TG_2024_001_reg.pdf',
            'is_verified' => true,
            'verified_by_user_id' => $admissionsExec->id,
        ]);

        StudentDocument::create([
            'student_id' => $student1->id,
            'title' => 'Parent Consent & Medical Declaration',
            'document_type' => 'parent_consent',
            'file_path' => 'documents/TG_2024_001_consent.pdf',
            'is_verified' => true,
            'verified_by_user_id' => $admissionsExec->id,
        ]);

        // 12. Leads across all pipeline stages
        $lead1 = Lead::create([
            'branch_id' => $branch1->id,
            'parent_name' => 'Sanjay Singhania',
            'student_name' => 'Kabir Singhania',
            'mobile' => '9810198101',
            'whatsapp' => '9810198101',
            'email' => 'sanjay@singhania.com',
            'student_age' => 9,
            'current_school' => 'Step By Step School',
            'current_class' => '4th Grade',
            'city' => 'Noida',
            'course_interest' => 'Midbrain Activation Program',
            'preferred_counselling_date' => Carbon::now()->addDays(1)->toDateString(),
            'preferred_counselling_time' => '11:30 AM',
            'lead_source_id' => $sourceWeb->id,
            'assigned_to_user_id' => $counsellor->id,
            'status' => 'counselling_scheduled',
            'notes' => 'Submitted online enquiry on talentgurukulindia.com for free brain counselling.',
            'followup_date' => Carbon::now()->addDays(1)->toDateString(),
            'followup_time' => '11:00:00',
            'followup_notes' => 'Call 30 minutes before appointment to confirm arrival.',
        ]);

        LeadActivity::create([
            'lead_id' => $lead1->id,
            'user_id' => $counsellor->id,
            'type' => 'call',
            'title' => 'Initial Enquiry Call',
            'description' => 'Spoke to father Sanjay. Explained Midbrain Activation and booked offline counselling slot at Noida centre.',
        ]);

        CounsellingAppointment::create([
            'lead_id' => $lead1->id,
            'counsellor_id' => $counsellor->id,
            'appointment_date' => Carbon::now()->addDays(1)->toDateString(),
            'appointment_time' => '11:30 AM',
            'mode' => 'offline',
            'status' => 'scheduled',
            'parent_concerns' => 'Child has short attention span and is addicted to mobile games.',
            'student_interests' => 'Loves Lego and puzzles.',
            'recommended_program' => 'Midbrain Activation + Photographic Memory',
            'admission_probability' => 85,
        ]);

        // Lead 2: New Enquiry
        Lead::create([
            'branch_id' => $branch1->id,
            'parent_name' => 'Meenakshi Iyer',
            'student_name' => 'Dhruv Iyer',
            'mobile' => '9711234567',
            'whatsapp' => '9711234567',
            'email' => 'meenakshi@gmail.com',
            'student_age' => 11,
            'current_school' => 'Amity International School',
            'current_class' => '6th Grade',
            'city' => 'Noida',
            'course_interest' => 'Photographic Memory Training',
            'lead_source_id' => $sourceInsta->id,
            'assigned_to_user_id' => $counsellor->id,
            'status' => 'new_enquiry',
            'notes' => 'Clicked Instagram Ad reel on Memory Techniques.',
            'followup_date' => Carbon::now()->toDateString(),
            'followup_time' => '02:00:00',
            'followup_notes' => 'Immediate first call required.',
        ]);

        // Lead 3: Followup Required
        Lead::create([
            'branch_id' => $branch2->id,
            'parent_name' => 'Pradeep Mathur',
            'student_name' => 'Isha Mathur',
            'mobile' => '9899123456',
            'whatsapp' => '9899123456',
            'email' => 'p.mathur@rediffmail.com',
            'student_age' => 13,
            'current_school' => 'DPS RK Puram',
            'current_class' => '8th Grade',
            'city' => 'New Delhi',
            'course_interest' => 'NLP & Mnemonics for Kids',
            'lead_source_id' => $sourceGoogle->id,
            'assigned_to_user_id' => $counsellor2->id,
            'status' => 'followup_required',
            'notes' => 'Attended counselling. Father discussing fee installment with family.',
            'followup_date' => Carbon::now()->toDateString(),
            'followup_time' => '04:30:00',
            'followup_notes' => 'Call Pradeep ji to confirm weekend batch enrollment.',
        ]);

        // Lead 4: Contact Pending
        Lead::create([
            'branch_id' => $branch1->id,
            'parent_name' => 'Anurag Kashyap',
            'student_name' => 'Tanya Kashyap',
            'mobile' => '9818889900',
            'whatsapp' => '9818889900',
            'email' => 'anurag.k@gmail.com',
            'student_age' => 7,
            'current_school' => 'Shiv Nadar School',
            'current_class' => '2nd Grade',
            'city' => 'Noida',
            'course_interest' => 'DMIT & Brain Profiling Counselling',
            'lead_source_id' => $sourceReferral->id,
            'assigned_to_user_id' => $counsellor->id,
            'status' => 'contact_pending',
            'notes' => 'Referred by Rajesh Sharma (Aarav parent).',
            'followup_date' => Carbon::now()->toDateString(),
            'followup_time' => '05:00:00',
            'followup_notes' => 'Reference of existing enrolled parent.',
        ]);

        // Lead 5: Admission Confirmed
        Lead::create([
            'branch_id' => $branch1->id,
            'parent_name' => 'Rajesh Sharma',
            'student_name' => 'Aarav Sharma',
            'mobile' => '9988776655',
            'whatsapp' => '9988776655',
            'email' => 'parent@gmail.com',
            'student_age' => 10,
            'current_school' => 'Delhi Public School, Noida',
            'current_class' => '5th Grade',
            'city' => 'Noida',
            'course_interest' => 'Photographic Memory Training',
            'lead_source_id' => $sourceWeb->id,
            'assigned_to_user_id' => $counsellor->id,
            'status' => 'admission_confirmed',
            'notes' => 'Successfully converted to registered student TG-2024-001.',
            'converted_student_id' => $student1->id,
        ]);

        // Lead 6: Lost Lead
        Lead::create([
            'branch_id' => $branch3->id,
            'parent_name' => 'Gaurav Rastogi',
            'student_name' => 'Siddharth Rastogi',
            'mobile' => '9415001122',
            'email' => 'grastogi@gmail.com',
            'student_age' => 14,
            'city' => 'Lucknow',
            'course_interest' => 'Vedic Maths',
            'lead_source_id' => $sourceFb->id,
            'assigned_to_user_id' => $counsellor->id,
            'status' => 'lost_lead',
            'notes' => 'Parent wanted online recorded videos only instead of live interactive sessions.',
        ]);

        // 13. Communication Logs
        CommunicationLog::create([
            'channel' => 'whatsapp',
            'recipient_type' => 'lead',
            'recipient_id' => $lead1->id,
            'recipient_phone_or_email' => '9810198101',
            'template_name' => 'counselling_booking_confirmation',
            'message_content' => 'Dear Sanjay ji, your Free Brain Assessment & Counselling session for Kabir is confirmed for Tomorrow at 11:30 AM at Talent Gurukul Noida Centre. Location: Sector 62. See you soon! - Talent Gurukul India',
            'status' => 'sent',
            'sent_by_user_id' => $counsellor->id,
        ]);

        CommunicationLog::create([
            'channel' => 'whatsapp',
            'recipient_type' => 'parent',
            'recipient_id' => $parent1->id,
            'recipient_phone_or_email' => '9988776655',
            'template_name' => 'payment_receipt_generated',
            'message_content' => 'Dear Rajesh Sharma, thank you for the payment of ₹13,500 for Aarav Sharma (Receipt #RCP-2024-001). We look forward to an enriching learning journey! - Talent Gurukul Team',
            'status' => 'sent',
            'sent_by_user_id' => $accountant->id,
        ]);

        // 14. Feedback Ticket
        FeedbackTicket::create([
            'ticket_number' => 'TCK-2024-001',
            'parent_id' => $parent1->id,
            'student_id' => $student1->id,
            'category' => 'Schedule',
            'subject' => 'Request for shifting Friday batch time by 30 mins',
            'description' => 'Aarav has school bus arriving at 3:30 PM on Fridays, requested if class can begin at 4:15 PM instead of 4:00 PM.',
            'priority' => 'low',
            'status' => 'resolved',
            'assigned_to_user_id' => $admissionsExec->id,
            'resolution_notes' => 'Adjusted trainer schedule. Batch now starts comfortably at 4:15 PM.',
        ]);

        // 15. Audit Logs
        AuditLog::create([
            'user_id' => $admin->id,
            'user_name' => 'Dr. Sameer Verma',
            'action' => 'system_setup',
            'module' => 'System',
            'description' => 'Talent Gurukul Student Lifecycle CRM initialized and database seeded successfully.',
            'ip_address' => '127.0.0.1',
        ]);

        AuditLog::create([
            'user_id' => $counsellor->id,
            'user_name' => 'Pooja Kashyap',
            'action' => 'created',
            'module' => 'leads',
            'record_id' => $lead1->id,
            'description' => 'Scheduled offline counselling for lead Sanjay Singhania (Kabir).',
            'ip_address' => '127.0.0.1',
        ]);
    }
}
