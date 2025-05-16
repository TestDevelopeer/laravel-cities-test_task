<?php

namespace App\Http\Controllers;

use App\Models\City;

class MainController extends Controller
{
    public function index()
    {
//        if (!$city && session('city')) {
//            return redirect()->route('index', ['city' => session('city.slug')], 302);
//        }
//
//        if ($city) {
//            $city_data = CitySlug::where('slug', $city)->firstOrFail();
//            session(['city' => $city_data]);
//        }
        
        $cities = City::all();

        return view('main.index', compact('cities'));
    }

    public function about()
    {
        return view('main.about');
    }

    public function news()
    {
        return view('main.news');
    }
}
