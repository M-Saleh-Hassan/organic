<?php

namespace App\Services\Weather;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.weather.key');
        $this->apiUrl = config('services.weather.url');
    }

    /**
     * Get current weather data by city name.
     *
     * @param string $city
     * @return string
     */
    public function getCurrentWeatherByCity($city)
    {
        $response = Http::get($this->apiUrl . 'weather', [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric', // Optional: For Celsius
        ]);

        return $response->json();
    }

    /**
     * Get weather forecast for a city.
     *
     * @param string $city
     * @return array
     */
    public function getWeatherForecastByCity($city)
    {
        $response = Http::get($this->apiUrl . 'forecast', [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        return $response->json();
    }

    public static function getWeatherIcon($code)
    {
        return 'https://openweathermap.org/img/wn/'.$code.'@2x.png';
    }
}
