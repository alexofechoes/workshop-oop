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
     * @var array
     */
    private $instanceServices = [];

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
     * @param string|null $serviceName
     * @return WeatherData
     */
    public function getForecast(string $city, string $serviceName = null): WeatherData
    {
        if ($serviceName) {
            return $this->createService($serviceName)->getForecast($city);
        }

        return $this->service->getForecast($city);
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

        if (!array_key_exists($serviceName, $this->instanceServices)) {
            $this->instanceServices[$serviceName] = new $this->services[$serviceName];
        }

        return $this->instanceServices[$serviceName];
    }
}