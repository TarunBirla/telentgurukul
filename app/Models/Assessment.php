<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'assessment_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function enrolment()
    {
        return $this->belongsTo(Enrolment::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
