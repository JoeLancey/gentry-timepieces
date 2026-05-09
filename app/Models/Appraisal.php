<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Appraisal extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CHECKING = 'checking';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'watch_id',
        'client_id',
        'appraiser_id',
        'appraised_value',
        'condition_notes',
        'review_notes',
        'has_box',
        'has_papers',
        'status',
        'workflow_status',
        'completed_at',
        'authenticity_conclusion',
        'documentation_quality',
    ];

    protected $casts = [
        'appraised_value' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['workflow_status'] ?? $value,
            set: fn ($value) => ['workflow_status' => $value],
        );
    }

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
        return $query->where('workflow_status', self::STATUS_COMPLETED);
    }

    public function scopePending($query)
    {
        return $query->where('workflow_status', self::STATUS_PENDING);
    }

    public function scopeChecking($query)
    {
        return $query->where('workflow_status', self::STATUS_CHECKING);
    }

    public function scopeRejected($query)
    {
        return $query->where('workflow_status', self::STATUS_REJECTED);
    }

    public function scopeByAppraiser($query, $userId)
    {
        return $query->where('appraiser_id', $userId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->whereBetween('created_at', [now()->subDays($days), now()]);
    }

    public function isFinalized(): bool
    {
        return in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_REJECTED], true);
    }
}