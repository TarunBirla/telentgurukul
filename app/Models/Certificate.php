<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded = [];

    protected $casts = [
        'issue_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrolment()
    {
        return $this->belongsTo(Enrolment::class);
    }
}
