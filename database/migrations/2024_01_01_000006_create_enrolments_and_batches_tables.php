<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrolments', function (Blueprint $table) {
            $table->id();
            $table->string('enrolment_number')->unique(); // ENR-2024-001
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('course_package_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('counsellor_id')->nullable();
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->date('admission_date');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('total_fee', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('final_payable', 10, 2)->default(0.00);
            $table->decimal('paid_amount', 10, 2)->default(0.00);
            $table->decimal('due_balance', 10, 2)->default(0.00);
            $table->string('status')->default('active'); // active, completed, paused, cancelled
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });

        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_code')->unique(); // BTH-MEM-01
            $table->string('batch_name');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('days_of_week')->default('Mon,Wed,Fri');
            $table->string('class_time')->default('04:00 PM - 05:30 PM');
            $table->integer('max_capacity')->default(15);
            $table->string('status')->default('running'); // upcoming, running, completed, suspended
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

        Schema::create('batch_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('enrolment_id')->nullable();
            $table->date('joined_date')->nullable();
            $table->string('status')->default('active'); // active, completed, dropped
            $table->timestamps();

            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_students');
        Schema::dropIfExists('batches');
        Schema::dropIfExists('enrolments');
    }
};
