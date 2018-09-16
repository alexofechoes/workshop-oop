<?php

namespace Php\Package\Weather;

class WeatherServiceFactory
{
    private $services;

    /**
     * @param array $services
     */
    public function __construct(array $services)
    {
       $this->services = $services;
    }

    /**
     * @param string $serviceName
     * @return WeatherServiceInterface
     *
     * @throw InvalidArgumentException
     */
    public function createService($serviceName): WeatherServiceInterface
    {
        if (!in_array($serviceName, array_keys($this->services))) {
            throw new \InvalidArgumentException('Service not supported');
        }

        return new $this->services[$serviceName];
    }
}