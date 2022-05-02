<?php

namespace App\Providers;

use App\Events\WeatherReportProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailWeatherReportProcessed
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
     * @param  \App\Events\WeatherReportProcessed  $event
     * @return void
     */
    public function handle(WeatherReportProcessed $event)
    {
        //
    }
}
