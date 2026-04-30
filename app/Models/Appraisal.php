<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appraisal extends Model
{
    use HasFactory;

    protected $fillable = [
        'watch_id',
        'client_id',
        'appraiser_id',
        'appraised_value',
        'condition_notes',
        'has_box',
        'has_papers',
        'status',
        'completed_at',
        'authenticity_conclusion',
        'documentation_quality',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function watch()
    {
        return $this->belongsTo(Watch::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function appraiser()
    {   
        return $this->belongsTo(User::class, 'appraiser_id');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByAppraiser($query, $userId)
    {
        return $query->where('appraiser_id', $userId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->whereBetween('created_at', [now()->subDays($days), now()]);
    }
}