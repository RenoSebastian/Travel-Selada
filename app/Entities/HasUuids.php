<?php

namespace App\Entities;

use Illuminate\Support\Str;

trait HasUuids
{
    /**
     * Boot function from Laravel.
     */
    protected static function bootHasUuids()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
