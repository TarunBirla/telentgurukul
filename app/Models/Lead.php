<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $guarded = [];

    protected $casts = [
        'student_dob' => 'date',
        'preferred_counselling_date' => 'date',
        'followup_date' => 'date',
        'is_duplicate' => 'boolean',
    ];

    public function source()
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function activities()
    {
        return $this->hasMany(LeadActivity::class)->orderBy('created_at', 'desc');
    }

    public function counsellingAppointments()
    {
        return $this->hasMany(CounsellingAppointment::class);
    }

    public function convertedStudent()
    {
        return $this->belongsTo(Student::class, 'converted_student_id');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'new_enquiry' => ['bg' => 'bg-primary-subtle text-primary border-primary', 'label' => 'New Enquiry'],
            'contact_pending' => ['bg' => 'bg-warning-subtle text-warning border-warning', 'label' => 'Contact Pending'],
            'contacted' => ['bg' => 'bg-info-subtle text-info border-info', 'label' => 'Contacted'],
            'interested' => ['bg' => 'bg-success-subtle text-success border-success', 'label' => 'Interested'],
            'counselling_scheduled' => ['bg' => 'bg-purple-subtle text-purple border-purple', 'label' => 'Counselling Scheduled'],
            'counselling_completed' => ['bg' => 'bg-indigo-subtle text-indigo border-indigo', 'label' => 'Counselling Done'],
            'followup_required' => ['bg' => 'bg-orange-subtle text-orange border-orange', 'label' => 'Follow-up Due'],
            'admission_confirmed' => ['bg' => 'bg-success text-white', 'label' => 'Admission Confirmed'],
            'not_interested' => ['bg' => 'bg-secondary-subtle text-secondary border-secondary', 'label' => 'Not Interested'],
            'lost_lead' => ['bg' => 'bg-danger-subtle text-danger border-danger', 'label' => 'Lost Lead'],
        ];

        return $badges[$this->status] ?? ['bg' => 'bg-light text-dark', 'label' => ucfirst(str_replace('_', ' ', $this->status))];
    }
}
