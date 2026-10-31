<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // parent login account
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('primary_mobile')->unique();
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->default('Uttar Pradesh');
            $table->string('communication_preference')->default('whatsapp');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id_number')->unique(); // e.g. TG-2024-001
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('dob')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable(); // Male, Female, Other
            $table->string('school_name')->nullable();
            $table->string('current_class')->nullable();
            $table->string('photo')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('blood_group')->nullable();
            $table->date('admission_date')->nullable();
            $table->string('status')->default('active'); // active, inactive, completed, dropped
            $table->text('medical_notes')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('parents');
    }
};
