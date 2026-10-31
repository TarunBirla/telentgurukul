<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function batchStudents()
    {
        return $this->hasMany(BatchStudent::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'batch_students');
    }

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
