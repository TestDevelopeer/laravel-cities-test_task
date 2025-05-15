<?php

namespace App\Helpers;

use App\Models\City;

class CitySlug
{
    public static function getSlug()
    {
        $slug = request()->segment(1, '');

        if ($slug) {
            $city = City::where('slug', $slug)->first();
            if ($city) {
                return $city->slug;
            }
        }
        return '';
    }
}
