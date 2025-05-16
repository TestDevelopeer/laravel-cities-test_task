<?php

if (!function_exists('city_url')) {
    function city_url($path, $city = null)
    {
        // Макро withCity с генерацией url для именных роутов (AppServiceProvider)
        return URL::withCity($path, $city);
    }
}
