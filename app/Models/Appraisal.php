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
}