<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunicationLog extends Model
{
    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by_user_id');
    }
}
