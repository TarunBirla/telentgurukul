<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'admission_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'total_fee' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_payable' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_balance' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function coursePackage()
    {
        return $this->belongsTo(CoursePackage::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function counsellor()
    {
        return $this->belongsTo(User::class, 'counsellor_id');
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function invoices()
    {
        return $this->hasMany(StudentInvoice::class);
    }
}
