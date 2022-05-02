<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'city' => [
                'name' => $this->city,
                'country' => $this->data['sys']['country'],
                'timezone' => $this->data['timezone'],
                'sunrise' => $this->data['sys']['sunrise'],
                'sunset' => $this->data['sys']['sunset'],
                'coordinates' => [
                    'lat' => $this->data['coord']['lat'],
                    'lon' => $this->data['coord']['lon'],
                ],
            ],
            'temperature' => [
                'current' => $this->data['main']['temp'],
                'min' => $this->data['main']['temp_min'],
                'max' => $this->data['main']['temp_max'],
                'feels_like' => $this->data['main']['feels_like'],
            ],
            'pressure' => $this->data['main']['pressure'],
            'humidity' => $this->data['main']['humidity'],
            'wind' => [
                'speed' => $this->data['wind']['speed'],
                'deg' => $this->data['wind']['deg'],
            ],
            'clouds' => $this->data['clouds']['all'],
            'weather' => [
                'main' => $this->data['weather'][0]['main'],
                'description' => $this->data['weather'][0]['description'],
                'icon' => 'http://openweathermap.org/img/wn/' . $this->data['weather'][0]['icon'] . '@2x.png',
                'visibility' => $this->data['visibility'],
            ],
            'date' => date('Y-m-d', $this->data['dt']),
        ];
    }
}
