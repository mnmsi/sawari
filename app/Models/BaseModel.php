<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class BaseModel extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            // Forget the cache for the updated model
            Cache::forget($model->getTable());
        });

        static::deleting(function ($model) {
            // Forget the cache for the updated model
            Cache::forget($model->getTable());
        });
    }

    private function delKeys($pattern): void
    {
        $redis = Redis::connection('cache');
        $keys = $redis->keys($pattern);

        foreach ($keys as $key) {
            $redis->del($key);
        }
    }
}
