<?php

namespace Php\Package\Weather;

interface WeatherServiceInterface
{
    /**
     * @param string $city
     * @return WeatherData
     */
    public function getData(string $city): WeatherData;
}
