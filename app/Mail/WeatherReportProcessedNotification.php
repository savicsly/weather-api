<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeatherReportProcessedNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var mixed|null
     */
    private mixed $exception;
    private $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event, $exception = null)
    {
        $this->event = $event;
        $this->exception = $exception;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('main.weather-report-processed', [
            'event' => $this->event,
            'exception' => $this->exception
        ]);
    }
}
