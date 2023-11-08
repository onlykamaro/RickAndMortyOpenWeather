<?php

namespace App;

use App\Models\City;
use Carbon\Carbon;
use GuzzleHttp\Client;

class WeatherApi
{
    private Client $client;
    private const API_URL = "https://Api.openweathermap.org/data/2.5/weather";

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false
        ]);
    }

    public function fetchCity(): City
    {
        $city = "sydney";
        $apiKey = $_ENV['API_KEY'];


        $response = $this->client->get(self::API_URL . "?q=$city&units=metric&appid=$apiKey");

        $result = json_decode((string)$response->getBody());

        $description = '';
        foreach ($result->weather as $item) {
            $description = $item->description;
        }

        return new City(
            $result->main->temp,
            $description,
            Carbon::parse($result->dt),
            $result->timezone,
            $result->name
        );
    }
}
