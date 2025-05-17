<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class City extends Model
{
    protected static function booted(): void
    {
        static::updated(function ($city) {
            Cache::forget('city_' . $city->slug);
        });

        static::deleted(function ($city) {
            Cache::forget('city_' . $city->slug);
        });
    }
}
