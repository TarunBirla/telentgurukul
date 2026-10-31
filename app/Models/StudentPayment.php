<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function invoice()
    {
        return $this->belongsTo(StudentInvoice::class, 'student_invoice_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collected_by_user_id');
    }
}
