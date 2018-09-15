<?php

namespace Php\Package\Weather;

class WeatherServiceFactory
{
    /**
     * @param $serviceName
     * @return MetaWeather|OtherWeather
     *
     * @throw InvalidArgumentException
     */
    public static function createService($serviceName)
    {
        if ($serviceName === 'metaweather') {
            return new MetaWeather();
        } elseif ($serviceName === 'otherweather'){
            return new OtherWeather();
        } else {
            throw new \InvalidArgumentException('Service not supported');
        }
    }
}