<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->integer('session_number')->default(1);
            $table->string('topic')->nullable();
            $table->date('class_date');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, conducted, cancelled, rescheduled
            $table->text('homework')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_schedule_id')->nullable();
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('student_id');
            $table->date('attendance_date');
            $table->string('status')->default('present'); // present, absent, late, leave
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('class_schedules');
    }
};
