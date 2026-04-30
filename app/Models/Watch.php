<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Watch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand',
        'model',
        'reference_number',
        'serial_number',
        'year_produced',
        'condition',
        'authenticity_status',
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

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function consignments()
    {
        return $this->hasMany(Consignment::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByCondition($query, $condition)
    {
        return $query->where('condition', $condition);
    }

    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', 'ilike', "%{$brand}%");
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('serial_number', 'like', "%{$search}%")
            ->orWhere('brand', 'like', "%{$search}%")
            ->orWhere('model', 'like', "%{$search}%");
    }

    // Accessors
    public function getProfitMarginAttribute()
    {
        if ($this->cost_price == 0) return 0;
        return round((($this->asking_price - $this->cost_price) / $this->cost_price) * 100, 2);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->asking_price, 2);
    }

    public function getConditionBadgeAttribute()
    {
        $colors = [
            'mint' => 'bg-green-500',
            'excellent' => 'bg-blue-500',
            'good' => 'bg-yellow-500',
            'fair' => 'bg-orange-500',
        ];
        return $colors[$this->condition] ?? 'bg-gray-500';
    }
}