<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('parent_name');
            $table->string('student_name')->nullable();
            $table->string('mobile');
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->date('student_dob')->nullable();
            $table->integer('student_age')->nullable();
            $table->string('current_school')->nullable();
            $table->string('current_class')->nullable();
            $table->string('city')->nullable();
            $table->string('location')->nullable();
            $table->string('course_interest')->nullable();
            $table->date('preferred_counselling_date')->nullable();
            $table->string('preferred_counselling_time')->nullable();
            $table->unsignedBigInteger('lead_source_id')->nullable();
            $table->unsignedBigInteger('assigned_to_user_id')->nullable();
            $table->string('status')->default('new_enquiry'); 
            // new_enquiry, contact_pending, contacted, interested, counselling_scheduled, counselling_completed, followup_required, admission_confirmed, not_interested, lost_lead
            $table->text('notes')->nullable();
            $table->date('followup_date')->nullable();
            $table->time('followup_time')->nullable();
            $table->text('followup_notes')->nullable();
            $table->boolean('is_duplicate')->default(false);
            $table->unsignedBigInteger('duplicate_of_lead_id')->nullable();
            $table->unsignedBigInteger('converted_student_id')->nullable();
            $table->timestamps();
        });

        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('type')->default('call'); // call, whatsapp, note, email, meeting, status_change
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_activities');
        Schema::dropIfExists('leads');
    }
};
