<?php

namespace App\Console\Commands;

use App\Jobs\ProcessWeatherReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchWeatherReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull the latest weather report from open weather API.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Began syncing latest weather report at ' . now());

        ProcessWeatherReport::dispatch();

        Log::info('Latest weather report syncing completed at' . now());
    }
}
