<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_login_at',
        'last_seen_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isOnline(): bool
    {
        $lastSeen = $this->last_seen_at ?? $this->last_login_at;

        return $lastSeen && $lastSeen->diffInMinutes(now()) < 5;
    }

    public function appraisals()
    {
        return $this->hasMany(Appraisal::class, 'appraiser_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'staff_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function watchFilters()
    {
        return $this->hasMany(WatchFilter::class);
    }
}