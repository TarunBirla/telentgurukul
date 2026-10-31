<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePackage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'included_course_ids' => 'array',
        'is_active' => 'boolean',
        'original_fee' => 'decimal:2',
        'package_fee' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];
}
