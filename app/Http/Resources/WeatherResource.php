<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
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
                'icon' => $this->data['weather'][0]['icon'] . '.png',
                'visibility' => $this->data['visibility'],
            ],
            'date' => Carbon::parse($this->data['dt'])->format('Y-m-d'),
        ];
    }
}
