<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchStudent extends Model
{
    protected $guarded = [];

    protected $casts = [
        'joined_date' => 'date',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
