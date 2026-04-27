<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'notes',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function appraisals()
    {
        return $this->hasMany(Appraisal::class);
    }

    public function consignments()
    {
        return $this->hasMany(Consignment::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}