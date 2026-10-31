<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    protected $table = 'parents';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }

    public function invoices()
    {
        return $this->hasMany(StudentInvoice::class, 'parent_id');
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class, 'parent_id');
    }

    public function feedbackTickets()
    {
        return $this->hasMany(FeedbackTicket::class, 'parent_id');
    }

    public function getDisplayNameAttribute()
    {
        return $this->father_name ?: ($this->mother_name ?: 'Parent #'.$this->id);
    }
}
