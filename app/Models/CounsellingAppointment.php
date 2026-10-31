<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounsellingAppointment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'appointment_date' => 'date',
        'next_followup_date' => 'date',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function counsellor()
    {
        return $this->belongsTo(User::class, 'counsellor_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
