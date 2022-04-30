<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    /** @test */
    public function a_user_can_view_weather_report_for_a_specific_date()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/weather', [
            'city' => 'London',
            'date' => '2020-01-01',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_view_weather_report_for_a_specific_city()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/weather', [
            'city' => 'London',
            'date' => '2020-01-01',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_view_weather_report_for_a_specific_city_and_date()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/weather', [
            'city' => 'London',
            'date' => '2020-01-01',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_city_is_required_to_view_weather_report()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/weather', [
            'city' => '',
            'date' => '2020-01-01',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function a_date_is_required_to_view_weather_report()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/weather', [
            'city' => 'London',
            'date' => '',
        ]);

        $response->assertStatus(422);
    }

}
