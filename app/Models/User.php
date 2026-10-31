<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'branch_id',
        'avatar',
        'is_active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function parentProfile()
    {
        return $this->hasOne(ParentModel::class, 'user_id');
    }

    public function assignedLeads()
    {
        return $this->hasMany(Lead::class, 'assigned_to_user_id');
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'trainer_id');
    }

    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'super_admin', 'owner', 'branch_manager']);
    }

    public function isCounsellor()
    {
        return $this->role === 'counsellor';
    }

    public function isTrainer()
    {
        return $this->role === 'trainer';
    }

    public function isAccountant()
    {
        return $this->role === 'accountant';
    }

    public function isParent()
    {
        return $this->role === 'parent';
    }
}
