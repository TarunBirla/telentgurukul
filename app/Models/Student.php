<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    protected $casts = [
        'dob' => 'date',
        'admission_date' => 'date',
    ];

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function enrolments()
    {
        return $this->hasMany(Enrolment::class);
    }

    public function batchStudents()
    {
        return $this->hasMany(BatchStudent::class);
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batch_students');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function invoices()
    {
        return $this->hasMany(StudentInvoice::class);
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class)->orderBy('assessment_date', 'asc');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getAttendancePercentageAttribute()
    {
        $total = $this->attendances()->count();
        if ($total == 0) return 100;
        $present = $this->attendances()->whereIn('status', ['present', 'late'])->count();
        return round(($present / $total) * 100, 1);
    }
}
