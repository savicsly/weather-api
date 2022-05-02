<?php

namespace App\Jobs;

use App\Enums\Cities;
use App\Events\WeatherReportProcessed;
use App\Models\Weather;
use App\Services\OpenWeatherApiService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessWeatherReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public int $backoff = 60;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $openWeatherApiService = new OpenWeatherApiService();

        $cities = Cities::getAll();

        foreach($cities as $city) {

            $response = $openWeatherApiService->getWeatherReport($city);

            $weather = Weather::query()
                ->where('city', $city)
                ->where('date', Carbon::parse(now())->format('Y-m-d'))
                ->first();

            if(!$weather) {
                $weather = new Weather();
                $weather->city = $city;
                $weather->date = Carbon::now()->toDateString();
            }

            $weather->data = $response;
            $weather->save();
        }

        WeatherReportProcessed::dispatch();
    }
}
