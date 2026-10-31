<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackTicket extends Model
{
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }
}
