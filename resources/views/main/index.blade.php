@extends('layouts.layout')

@section('content')
    <h1>Main Page</h1>

    <ul>
        @foreach($cities as $city)
            <li>
                <a @class([
    'fw-bold' => session('city') && session('city.slug') === $city->slug
]) href="{{ route('index', ['city' => $city->slug]) }}">{{ $city->title }}</a>
            </li>
        @endforeach
    </ul>
@endsection
