<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
