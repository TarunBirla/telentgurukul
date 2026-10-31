<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // INV-2024-001
            $table->unsignedBigInteger('enrolment_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('title')->default('Course Fee');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('final_payable', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0.00);
            $table->decimal('balance_due', 10, 2)->default(0.00);
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->string('status')->default('unpaid'); // unpaid, partially_paid, paid, overdue
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });

        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique(); // RCP-2024-001
            $table->unsignedBigInteger('student_invoice_id');
            $table->unsignedBigInteger('enrolment_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->string('payment_method')->default('upi'); // cash, upi, bank_transfer, card, cheque
            $table->string('transaction_reference')->nullable();
            $table->unsignedBigInteger('collected_by_user_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('student_invoice_id')->references('id')->on('student_invoices')->onDelete('cascade');
        });

        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->string('refund_number')->unique();
            $table->unsignedBigInteger('student_payment_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->decimal('amount', 10, 2);
            $table->date('refund_date');
            $table->string('reason');
            $table->string('status')->default('approved');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('student_payments');
        Schema::dropIfExists('student_invoices');
    }
};
