<?php

namespace Php\Package\Weather;

class WeatherServiceFactory
{
    private static $services = [
        'metaweather' => MetaWeather::class,
        'otherweather' => OtherWeather::class,
    ];

    /**
     * @param $serviceName
     * @return MetaWeather|OtherWeather
     *
     * @throw InvalidArgumentException
     */
    public static function createService($serviceName)
    {
        if (!in_array($serviceName, array_keys(self::$services))) {
            throw new \InvalidArgumentException('Service not supported');
        }

        return new self::$services[$serviceName];
    }
}