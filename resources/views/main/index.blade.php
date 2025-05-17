@extends('layouts.layout')

@section('content')
    <h1>Main Page</h1>

    @if(session()->get('allCities') !== null)
        Retrieved cities: <b>{{ session()->get('allCities') }}</b> | Inserted cities: <b>{{ session()->get('insertedCities') }}</b> | Ignored: <b>{{ session()->get('ignored') }}</b>
        <br><br>
    @endif

    <ul style="column-count: 5">
        @foreach($cities as $city)
            <li>
                <a @class([
    'fw-bold' => session('city.slug') && session('city.slug') === $city->slug
]) href="{{ city_url(route('index'), $city->slug) }}">{{ $city->title }}</a>
            </li>
        @endforeach
    </ul>
@endsection
