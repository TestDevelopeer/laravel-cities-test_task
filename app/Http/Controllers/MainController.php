<?php

namespace App\Http\Controllers;

use App\Models\City;

class MainController extends Controller
{
    public function index()
    {
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
