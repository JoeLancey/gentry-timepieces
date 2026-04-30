<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'watch_id',
        'client_id',
        'agreed_price',
        'commission_rate',
        'status',
        'start_date',
        'end_date',
        'notes',
        'commission_paid',
        'commission_paid_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'commission_paid_at' => 'datetime',
    ];

    public function watch()
    {
        return $this->belongsTo(Watch::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeExpiringSoon($query)
    {
        return $query->where('end_date', '<=', now()->addDays(7))
            ->where('status', 'active');
    }

    // Accessors
    public function getCommissionAmountAttribute()
    {
        return round($this->agreed_price * $this->commission_rate / 100, 2);
    }

    public function getNetAmountAttribute()
    {
        return round($this->agreed_price - $this->commission_amount, 2);
    }

    public function getDaysRemainingAttribute()
    {
        if (!$this->end_date) return null;
        return $this->end_date->diffInDays(now());
    }

    public function getIsExpiringSoonAttribute()
    {
        return $this->days_remaining !== null && $this->days_remaining <= 7;
    }
}