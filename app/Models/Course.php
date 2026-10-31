<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    protected $casts = [
        'has_certificate' => 'boolean',
        'has_assessment' => 'boolean',
        'is_active' => 'boolean',
        'course_fee' => 'decimal:2',
        'registration_fee' => 'decimal:2',
    ];

    public function enrolments()
    {
        return $this->hasMany(Enrolment::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
