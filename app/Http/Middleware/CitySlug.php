<?php

namespace App\Http\Middleware;

use App\Models\City;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CitySlug
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Разбиваем строку url по /
        $segments = explode('/', trim($request->path(), '/'));
        $city = false; // Город еще неизвестен

        // Если url не пустой и первый элемент после домена не пустой
        if (!empty($segments) && $segments[0] !== "") {
            $citySlug = $segments[0]; // Первым элементом всегда должен быть город, получаем его

            // Получаем город из БД или кэша по первому элементу url строки и кэшируем запрос к БД
            $city = City::where('slug', $citySlug)->first(); // Ищем город в таблице по slug
            if(!$city){
                session()->forget('city');
                //return redirect()->route('index');
            }
        }

        // Если город по первому элементу был ранее найден в БД
        if ($city) {
            array_shift($segments); // Из разбитого массива url убираем первый элемент (наш город)
            // Перезаписываем URI, уже без города
            $newUri = '/' . implode('/', $segments); // /london/about => /about
            $request->server->set('REQUEST_URI', $newUri); // устанавливаем новый url в request
            $request = Request::createFrom($request); // пересобираем request
        }

        // заносим город в атрибут request, чтобы middleware редиректа понимал,
        // был ли найден город в бд или нет
        $request->attributes->set('city', $city);

        // Далее запрос уйдет в CityRedirect middleware, так, как в этом session('city') всегда возвращает NULL
        // поэтому не могу тут сделать редирект на ранее выбранный город, если url пришел без него
        return $next($request);
    }
}
