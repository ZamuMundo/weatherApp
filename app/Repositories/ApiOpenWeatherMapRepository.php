<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

//use Your Model

/**
 * Class ApiOpenWeatherMapRepository.
 */
class ApiOpenWeatherMapRepository
{
    /**
     * @param String $city
     *
     * @return Json $response
     */
    public function getApiWeather($city)
    {
        $api_key = env('API_KEY');
        $base_url = env('API_OPENWEATHER_URL_BASE');
        $appid_url = env('API_OPENWEATHER_URL_APPID');
        $params_url = env('API_OPENWEATHER_URL_PARAMS');

        $api_url = $base_url.$city.$appid_url.$api_key.$params_url ;
        $response = Http::get($api_url);

        return $response;
    }


    /**
     * Devuelve si ha llovido en un día especifico
     *
     * @param INT $lat
     * @param INT $lon
     * @param TIME $date_unix
     *
     * @return Bool
     */
    public function getApiHistoryRain($lat, $lon, $date_unix)
    {

         $base_url  = env('API_OPENWEATHER_HISTORY_URL_BASE');
         $lat_url   = env('API_OPENWEATHER_HISTORY_URL_LAT');
         $long_url  = env('API_OPENWEATHER_HISTORY_URL_LON');
         $dt_url    = env('API_OPENWEATHER_HISTORY_URL_DT');
         $appid_url = env('API_OPENWEATHER_HISTORY_URL_APPID');
         $api_key   = env('API_KEY');

        $api_url = $base_url.$lat_url.$lat.$long_url.$lon.$dt_url.$date_unix.$appid_url.$api_key;

         $response = Http::get($api_url);

         $body = json_decode( $response->body() );

         $current_collection = collect($body->current);

         $contains_rain = $current_collection->contains(function ($item, $key) {
             return $key == 'rain';
         });

        return $contains_rain;
     }

}
