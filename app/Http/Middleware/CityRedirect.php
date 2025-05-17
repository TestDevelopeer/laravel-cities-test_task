<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CityRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $city = $request->attributes->get('city'); // Получаем город из прошлого middleware
        // Если он есть, то он 100% верный, так как до этого он брался из БД
        if ($city) {
            session(['city' => $city]); // заносим город в сессию, для view и для middleware редиректа
        }
        // Проверяем пустой ли атрибут cached_city,
        // который устанавливается в прошлом middleware CitySlug
        // Если он NULL значит город не был передан в url
        // и если при этом сессия с выбранным городом присутствует, то мы перенаправим на url с выбранным ранее городом
        if ($city === null && session('city')) {
            // Использую свой helper city_url для генерации именных роутов с подстановкой города
            return redirect(city_url($request->path(), session('city.slug')));
        }
        return $next($request);
    }
}
