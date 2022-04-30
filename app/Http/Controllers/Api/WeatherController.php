<?php

namespace App\Http\Controllers\Api;

use App\Enums\Cities;
use App\Http\Controllers\Controller;
use App\Http\Resources\WeatherResource;
use App\Models\Weather;
use App\Services\OpenWeatherApiService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class WeatherController extends Controller
{
    /**
     * @var OpenWeatherApiService
     */
    public function __construct(
        protected OpenWeatherApiService $openWeatherApiService
    ){}


    /**
     * @OA\Get(
     *     path="/api/weather",
     *     tags={"Weather"},
     *     summary="Get weather",
     *     description="Get weather",
     *     operationId="getWeather",
     *     @OA\RequestBody(
     *         @OA\Property(property="city", type="string", example="London"),
     *         @OA\Property(property="date", type="string", example="2022-05-01"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="city",
     *                      type="object",
     *                      @OA\Property(property="name", type="string", example="London"),
     *                      @OA\Property(property="country", type="string", example="GB"),
     *                      @OA\Property(property="timezone", type="string", example="3600"),
     *                      @OA\Property(property="sunrise", type="string", example="1650689287"),
     *                      @OA\Property(property="sunset", type="string", example="1650740953"),
     *                      @OA\Property(
     *                          property="coordinates",
     *                          type="object",
     *                          @OA\Property(property="lat", type="string", example="51.5085"),
     *                          @OA\Property(property="lon", type="string", example="-0.1257"),
     *                     ),
     *                  ),
     *                  @OA\Property(
     *                      property="temprature",
     *                      type="object",
     *                      @OA\Property(property="current", type="string", example="16.36"),
     *                      @OA\Property(property="min", type="string", example="13.81"),
     *                      @OA\Property(property="max", type="string", example="17.85"),
     *                      @OA\Property(property="feels_like", type="string", example="15.57"),
     *                  ),
     *                  @OA\Property(property="pressure", type="string", example="1003"),
     *                  @OA\Property(property="humidity", type="string", example="58"),
     *                  @OA\Property(
     *                      property="wind",
     *                      type="object",
     *                      @OA\Property(property="speed", type="string", example="9.77"),
     *                      @OA\Property(property="deg", type="string", example="70"),
     *                  ),
     *                  @OA\Property(property="clouds", type="string", example="40"),
     *                  @OA\Property(
     *                      property="weather",
     *                      type="object",
     *                      @OA\Property(property="main", type="string", example="Clouds"),
     *                      @OA\Property(property="description", type="string", example="scattered clouds"),
     *                      @OA\Property(property="icon", type="string", example="03d.png"),
     *                      @OA\Property(property="visibility", type="string", example="10000"),
     *                  ),
     *                  @OA\Property(property="date", type="string", example="2022-05-01"),
     *             ),
     *        )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => ['required', 'string', new Enum(Cities::class)],
            'date' => ['required', 'date:Y-m-d'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $city = $request->input('city');
        $date = $request->input('date');

        $weather = Weather::where('city', $city)->where('date', $date)->first();

        if (!$weather) {

            $response = $this->openWeatherApiService->getWeather($city);

            $weather = new Weather();
            $weather->city = $city;
            $weather->date = Carbon::parse($date)->format('Y-m-d');
            $weather->data = json_encode($response);
            $weather->save();

//            $weather = Weather::create([
//                'city' => $city,
//                'date' => Carbon::parse($date)->format('Y-m-d'),
//                'data' => json_encode($response)
//            ]);
        }

        return (new WeatherResource($weather))
            ->response()
            ->setStatusCode(200);

    }
}
