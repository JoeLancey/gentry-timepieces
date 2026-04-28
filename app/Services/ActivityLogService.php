<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    public static function logCreate(Model $model, $description = null)
    {
        ActivityLog::log('created', class_basename($model), $model->id, null, $description ?? class_basename($model) . ' created');
    }

    public static function logUpdate(Model $model, array $oldValues, $description = null)
    {
        $changes = [];
        foreach ($oldValues as $field => $oldValue) {
            $newValue = $model->{$field};
            if ($oldValue != $newValue) {
                $changes[$field] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }

        if (!empty($changes)) {
            ActivityLog::log('updated', class_basename($model), $model->id, $changes, $description ?? class_basename($model) . ' updated');
        }
    }

    public static function logDelete(Model $model, $description = null)
    {
        ActivityLog::log('deleted', class_basename($model), $model->id, null, $description ?? class_basename($model) . ' deleted');
    }

    public static function logRestore(Model $model, $description = null)
    {
        ActivityLog::log('restored', class_basename($model), $model->id, null, $description ?? class_basename($model) . ' restored');
    }

    public static function logApproval(Model $model, $approved, $description = null)
    {
        $action = $approved ? 'approved' : 'rejected';
        ActivityLog::log($action, class_basename($model), $model->id, null, $description ?? class_basename($model) . ' ' . $action);
    }

    public static function logBulkAction($modelType, array $modelIds, $action, $description = null)
    {
        foreach ($modelIds as $modelId) {
            ActivityLog::log('bulk_' . $action, $modelType, $modelId, null, $description ?? 'Bulk ' . $action . ' performed');
        }
    }
}
