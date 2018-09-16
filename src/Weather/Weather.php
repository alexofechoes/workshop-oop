<?php

namespace Php\Package\Weather;

class Weather
{
    private $services = [
        'meta-weather' => MetaWeather::class,
        'other-weather' => OtherWeather::class
    ];

    /**
     * @var WeatherServiceInterface
     */
    private $service;

    /**
     * @param string $serviceName
     * @param array $additionalServices
     */
    public function __construct(string $serviceName, array $additionalServices = [])
    {
       $this->services = array_merge($this->services,$additionalServices);
       $this->service = $this->createService($serviceName);
    }

    /**
     * @param $city
     * @return WeatherData
     */
    public function getData(string $city): WeatherData
    {
        return $this->service->getData($city);
    }

    /**
     * @param string $serviceName
     * @return WeatherServiceInterface
     *
     * @throw InvalidArgumentException
     */
    private function createService($serviceName): WeatherServiceInterface
    {
        if (!in_array($serviceName, array_keys($this->services))) {
            throw new \InvalidArgumentException('Service not supported');
        }

        return new $this->services[$serviceName];
    }
}