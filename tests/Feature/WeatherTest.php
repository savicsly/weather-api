<?php

namespace Tests\Feature;

use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_city_is_required_to_view_weather_report()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('get', '/api/weather', [
            'city' => '',
            'date' => '2020-01-01',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function a_valid_city_is_given()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('get', '/api/weather', [
            'city' => 'Lagos',
            'date' => '2020-01-01',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Validation error.',
                'error' => [
                    'city' => [
                        'The selected city is invalid.',
                    ],
                ],
            ]);
    }

    /** @test */
    public function a_date_is_required_to_view_weather_report()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('get', '/api/weather', [
            'city' => 'London',
            'date' => '',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Validation error.',
                'error' => [
                    'date' => [
                        'The date field is required.',
                    ],
                ],
            ]);
    }

    /** @test */
    public function a_city_and_date_is_required_to_view_weather_report()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('get', '/api/weather', [
            'city' => '',
            'date' => '',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Validation error.',
                'error' => [
                    'city' => [
                        'The city field is required.'
                    ],
                    'date' => [
                        'The date field is required.'
                    ]
                ],
            ]);
    }

    /** @test */
    public function a_user_can_view_weather_report_for_a_specific_city_and_date()
    {
        $weather = Weather::factory()->create([
            'city' => 'London',
            'date' => '2022-05-01',
        ]);


        $response = $this->json('get', '/api/weather', [
            'city' => $weather['city'],
            'date' => $weather['date'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'city' => [
                        'name' => $weather['city'],
                    ],
                    'date' => Carbon::parse($weather['date'])->format('Y-m-d'),
                ],
            ]);
    }
}
