<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'changes',
        'description',
    ];

    protected $casts = [
        'changes' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getModelAttribute()
    {
        $modelClass = 'App\\Models\\' . $this->model_type;
        if (class_exists($modelClass)) {
            return $modelClass::withTrashed()->find($this->model_id);
        }
        return null;
    }

    public static function log($action, $modelType, $modelId, $changes = null, $description = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'changes' => $changes,
            'description' => $description,
        ]);
    }
}
