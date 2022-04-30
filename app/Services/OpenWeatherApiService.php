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

    public function getWeather($city)
    {
        return Http::get("{$this->baseUrl}?q={$city}&appid={$this->apiKey}&units=metric")->json();
    }
}
