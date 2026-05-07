<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'watch_id',
        'client_id',
        'staff_id',
        'trade_in_watch_id',
        'type',
        'amount',
        'trade_in_appraisal_value',
        'trade_in_cash_from',
        'invoice_number',
        'notes',
    ];

    public function watch()
    {
        return $this->belongsTo(Watch::class);
    }

    public function tradeInWatch()
    {
        return $this->belongsTo(Watch::class, 'trade_in_watch_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeSales($query)
    {
        return $query->where('type', 'sale');
    }

    public function scopeTradeIns($query)
    {
        return $query->where('type', 'trade_in');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getTotalPaidAttribute()
    {
        return $this->payments()->where('status', 'confirmed')->sum('amount');
    }

    public function getRemainingAmountAttribute()
    {
        return round($this->amount - $this->total_paid, 2);
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->total_paid >= $this->amount) return 'Paid';
        if ($this->total_paid > 0) return 'Partial';
        return 'Pending';
    }

    public function getIsFullyPaidAttribute()
    {
        return $this->total_paid >= $this->amount;
    }
}