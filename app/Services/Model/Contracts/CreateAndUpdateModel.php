<?php

namespace App\Services\Model\Contracts;

trait CreateAndUpdateModel
{
    protected static function boot()
    {
        parent::boot();

        //新增时
        static::creating(function ($model) {
            if (auth('sanctum')->check()) {
                $model->created_by = auth('sanctum')->user()->user_id;
            }
        });

        //更新时
        static::updating(function ($model) {
            if (auth('sanctum')->check()) {
                $model->updated_by = auth('sanctum')->user()->user_id;
            }
        });
    }
}
