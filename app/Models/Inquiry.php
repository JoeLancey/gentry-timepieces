<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'watch_id',
        'inquiry_type',
        'status',
        'notes',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function watch()
    {
        return $this->belongsTo(Watch::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeResponded($query)
    {
        return $query->where('status', 'responded');
    }

    public function scopeConverted($query)
    {
        return $query->where('status', 'converted_to_sale');
    }

    public function scopeNoSale($query)
    {
        return $query->where('status', 'no_sale');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('inquiry_type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->whereBetween('created_at', [now()->subDays($days), now()]);
    }
}
