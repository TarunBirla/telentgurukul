<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counselling_appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('counsellor_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->date('appointment_date');
            $table->string('appointment_time')->nullable();
            $table->string('mode')->default('offline'); // offline, online
            $table->string('status')->default('scheduled'); // scheduled, completed, cancelled, no_show
            $table->text('parent_concerns')->nullable();
            $table->text('student_interests')->nullable();
            $table->string('recommended_program')->nullable();
            $table->string('outcome')->nullable(); // High Probability, Neutral, Low, Enrolled
            $table->integer('admission_probability')->default(50); // percentage 0-100
            $table->text('counsellor_remarks')->nullable();
            $table->date('next_followup_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counselling_appointments');
    }
};
