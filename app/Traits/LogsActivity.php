<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            ActivityLog::log(
                'created',
                class_basename($model) . ' created: ' . ($model->name ?? $model->id),
                class_basename($model),
                $model->id,
                $model->toArray()
            );
        });

        static::updated(function ($model) {
            ActivityLog::log(
                'updated',
                class_basename($model) . ' updated: ' . ($model->name ?? $model->id),
                class_basename($model),
                $model->id,
                $model->getChanges()
            );
        });

        static::deleted(function ($model) {
            ActivityLog::log(
                'deleted',
                class_basename($model) . ' deleted: ' . ($model->name ?? $model->id),
                class_basename($model),
                $model->id
            );
        });
    }
}