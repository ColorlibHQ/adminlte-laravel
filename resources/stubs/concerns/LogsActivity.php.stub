<?php

namespace App\Models\Concerns;

use ColorlibHQ\AdminLte\Support\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

/**
 * Add to any Eloquent model to automatically record create / update / delete
 * events into the activity_log table:
 *
 *     class Project extends Model
 *     {
 *         use \App\Models\Concerns\LogsActivity;
 *     }
 */
trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            ActivityLogger::log('created', class_basename($model).' created', [], $model);
        });

        static::updated(function (Model $model) {
            ActivityLogger::log('updated', class_basename($model).' updated', $model->getChanges(), $model);
        });

        static::deleted(function (Model $model) {
            ActivityLogger::log('deleted', class_basename($model).' deleted', [], $model);
        });
    }
}
