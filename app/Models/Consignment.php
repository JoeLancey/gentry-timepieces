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
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function watch()
    {
        return $this->belongsTo(Watch::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}