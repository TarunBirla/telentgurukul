<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $guarded = [];

    protected $casts = [
        'class_date' => 'date',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
