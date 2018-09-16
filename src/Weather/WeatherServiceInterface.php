<?php

namespace Php\Package\Weather;

interface WeatherServiceInterface
{
    /**
     * @param string $city
     * @return WeatherData
     */
    public function getForecast(string $city): WeatherData;
}
