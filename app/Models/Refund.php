<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
