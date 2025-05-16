@extends('layouts.layout')

@section('content')
    <h1>Main Page</h1>

    <ul>
        @foreach($cities as $city)
            <li>
                <a @class([
    'fw-bold' => session('city.slug') && session('city.slug') === $city->slug
]) href="{{ city_url(route('index'), $city->slug) }}">{{ $city->title }}</a>
            </li>
        @endforeach
    </ul>
@endsection
