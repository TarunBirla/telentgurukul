<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentInvoice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_payable' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];

    public function enrolment()
    {
        return $this->belongsTo(Enrolment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class, 'student_invoice_id');
    }
}
