<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->default('Brain Development'); // Brain Development, Memory, Academics, Counselling
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('duration_days')->default(30);
            $table->integer('total_sessions')->default(15);
            $table->integer('session_minutes')->default(60);
            $table->decimal('course_fee', 10, 2)->default(10000.00);
            $table->decimal('registration_fee', 10, 2)->default(1000.00);
            $table->integer('max_batch_capacity')->default(15);
            $table->boolean('has_certificate')->default(true);
            $table->boolean('has_assessment')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('course_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('included_course_ids')->nullable();
            $table->decimal('original_fee', 10, 2)->default(0.00);
            $table->decimal('package_fee', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->integer('duration_days')->default(60);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_packages');
        Schema::dropIfExists('courses');
    }
};
