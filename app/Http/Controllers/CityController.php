<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CityController extends Controller
{
    private const COUNTRY = 'russia';

    /**
     * @throws ConnectionException
     */
    public function getCities()
    {
        $data = Http::retry(3, 100, throw: false)->post('https://countriesnow.space/api/v0.1/countries/cities', [
            'country' => self::COUNTRY,
        ])->json();

        if ($data['error']) {
            return $data['msg'];
        }

        City::query()->truncate();

        $data_chunks = array_chunk($data['data'], 500);
        $ignored = 0;

        foreach ($data_chunks as $chunk) {
            $values = [];
            foreach ($chunk as $item) {
                $values[] = [
                    'title' => $item,
                    'slug' => Str::slug($item),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $inserts = DB::table('cities')->insertOrIgnore($values);
            $ignored += (count($values) - $inserts);
        }

        $allCities = count($data['data']);
        $insertedCities = $allCities - $ignored;

        session()->forget('city');

        return redirect()->route('index')->with(compact('allCities', 'insertedCities', 'ignored'));
    }
}
