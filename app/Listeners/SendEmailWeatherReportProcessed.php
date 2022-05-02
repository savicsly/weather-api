<?php

namespace App\Listeners;

use App\Events\WeatherReportProcessed;
use App\Mail\WeatherReportProcessedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailWeatherReportProcessed implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param WeatherReportProcessed $event
     * @return void
     */
    public function handle(WeatherReportProcessed $event): void
    {
        Log::debug((string)$event);

        if(true) {
            Mail::to(config('app.admin_email'))->send(new WeatherReportProcessedNotification($event));
        }
    }

    public function failed(WeatherReportProcessed $event, $exception): void
    {
        Mail::to(config('app.admin_email'))->send(new WeatherReportProcessedNotification($event, $exception));
    }
}
