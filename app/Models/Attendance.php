<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    public function schedule()
    {
        return $this->belongsTo(ClassSchedule::class, 'class_schedule_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
