<?php

namespace App\Models;

use Carbon\Carbon;

class City
{
    private float $temperature;
    private string $description;
    private Carbon $dayTime;
    private int $timezone;
    private string $cityName;

    public function __construct(
        float $temperature,
        string $description,
        Carbon $dayTime,
        int $timezone,
        string $cityName
    )
    {
        $this->temperature = $temperature;
        $this->description = $description;
        $this->dayTime = $dayTime;
        $this->timezone = $timezone;
        $this->cityName = $cityName;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDayTime(): Carbon
    {
        return $this->dayTime;
    }

    public function getTimezone(): int
    {
        return $this->timezone;
    }

    public function getCityName(): string
    {
        return $this->cityName;
    }

    public function setDayTime(Carbon $dayTime): void
    {
        $this->dayTime = $dayTime;
    }
}