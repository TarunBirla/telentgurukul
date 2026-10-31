<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communication_logs', function (Blueprint $table) {
            $table->id();
            $table->string('channel')->default('whatsapp'); // whatsapp, sms, email
            $table->string('recipient_type')->default('lead'); // lead, parent, student
            $table->unsignedBigInteger('recipient_id')->nullable();
            $table->string('recipient_phone_or_email');
            $table->string('template_name')->nullable();
            $table->text('message_content');
            $table->string('status')->default('sent'); // sent, failed, pending
            $table->unsignedBigInteger('sent_by_user_id')->nullable();
            $table->timestamps();
        });

        Schema::create('feedback_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('category')->default('Course Experience'); // Course Experience, Trainer, Schedule, Fee, General
            $table->string('subject');
            $table->text('description');
            $table->string('priority')->default('medium'); // low, medium, high
            $table->string('status')->default('open'); // open, in_progress, resolved, closed
            $table->unsignedBigInteger('assigned_to_user_id')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('action'); // created, updated, deleted, status_changed, login
            $table->string('module'); // leads, students, fees, attendance, etc.
            $table->unsignedBigInteger('record_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('feedback_tickets');
        Schema::dropIfExists('communication_logs');
    }
};
