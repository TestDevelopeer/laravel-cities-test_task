<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Генерация URL с городом
        URL::macro('withCity', function ($path, $city = null) {
            $city = $city ?: Request::get('city'); // Город передан в макро или из запроса

            // Если передан полный URL (http://...), извлекаем путь
            if (Str::startsWith($path, ['http://', 'https://'])) {
                $parsed = parse_url($path);
                $path = $parsed['path'] ?? '';
                $port = $parsed['port'] ? ':' . $parsed['port'] : '';
                $query = isset($parsed['query']) ? "?{$parsed['query']}" : '';
                $fragment = isset($parsed['fragment']) ? "#{$parsed['fragment']}" : '';

                $newPath = $city ? "/{$city}{$path}" : $path;
                return ($parsed['scheme'] ?? 'https') . "://{$parsed['host']}{$port}{$newPath}{$query}{$fragment}";
            }

            // Для относительных путей
            $path = ltrim($path, '/');
            return $city ? "/{$city}/{$path}" : "/{$path}";
        });
    }
}
