<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('enrolment_id')->nullable();
            $table->string('assessment_type')->default('before'); // before, mid, after
            $table->date('assessment_date');
            $table->integer('memory_score')->default(50); // 0-100
            $table->integer('concentration_score')->default(50); // 0-100
            $table->integer('reading_speed_wpm')->default(120); // words per minute
            $table->integer('recall_accuracy_pct')->default(60); // percentage
            $table->integer('confidence_score')->default(50); // 0-100
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->text('observations')->nullable();
            $table->text('parent_feedback')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique(); // TG-CERT-2024-001
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('enrolment_id')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->date('issue_date');
            $table->string('grade')->default('A+');
            $table->string('authorized_by')->default('Program Director');
            $table->string('status')->default('issued'); // issued, revoked
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('title');
            $table->string('document_type')->default('registration_form'); // registration_form, parent_consent, photo, birth_cert, other
            $table->string('file_path')->nullable();
            $table->boolean('is_verified')->default(true);
            $table->unsignedBigInteger('verified_by_user_id')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_documents');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('assessments');
    }
};
