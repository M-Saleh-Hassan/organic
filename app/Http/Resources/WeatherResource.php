<?php

namespace App\Http\Resources;

use App\Services\Weather\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    protected $forDatabase;

    // Modify the constructor to accept additional data
    public function __construct($resource, $forDatabase = false)
    {
        parent::__construct($resource);
        $this->forDatabase = $forDatabase;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->forDatabase) return $this->forDatabase();

        if($this['cod'] != 200) return [
            'temp'        => 0,
            'condition'   => null,
            'description' => null,
            'icon'        => null,
        ];

        return [
            'temp'        => $this['main']['temp'],
            'condition'   => $this['weather'][0]['main'],
            'description' => $this['weather'][0]['description'],
            'icon'        => WeatherService::getWeatherIcon($this['weather'][0]['icon']),
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function forDatabase(): array
    {
        if($this['cod'] != 200) return [
            'temp'        => 0,
            'condition'   => null,
            'description' => null,
            'icon'        => null,
        ];

        return [
            'weather' => $this['weather'],
            'main'    => $this['main'],
            'cod'     => $this['cod'],
        ];
    }
}
