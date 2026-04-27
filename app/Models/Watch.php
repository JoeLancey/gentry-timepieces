<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'reference_number',
        'serial_number',
        'year_produced',
        'condition',
        'has_box',
        'has_papers',
        'asking_price',
        'cost_price',
        'status',
        'image_path',
        'description',
    ];

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