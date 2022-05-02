<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenWeatherApiService
{
    protected mixed $apiKey;
    protected mixed $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.weather.apiKey');
        $this->baseUrl = config('services.weather.baseUrl');
    }

    public function getWeatherReport($city)
    {
        return Http::get("{$this->baseUrl}?q={$city}&appid={$this->apiKey}&units=metric")
            ->json();
    }

    public function getHistoricReport($city, $date)
    {
        $cord = $this->getCoordinates($city);
        $lat = $cord[0]['lat'];
        $lon = $cord[0]['lon'];


        if ($cord) {
            return Http::get("http://history.openweathermap.org/data/2.5/history/city?lat={$lat}&lon={$lon}&type=hour&start={$date}&appid={$this->apiKey}")
                ->json();
        }
    }

    public function getCoordinates($city)
    {
        return Http::get("http://api.openweathermap.org/geo/1.0/direct?q={$city}&appid={$this->apiKey}")
            ->json();
    }
}
