<?php

namespace Php\Package\Weather;

class WeatherData
{
    private $temp;
    private $pressure;
    private $humidity;
    private $windSpeed;

    /**
     * WeatherData constructor.
     *
     * @param string $temp
     * @param string $pressure
     * @param string $humidity
     * @param string $windSpeed
     */
    public function __construct(
        string $temp,
        string $pressure,
        string $humidity,
        string $windSpeed
    )
    {
        $this->temp = $temp;
        $this->pressure = $pressure;
        $this->humidity = $humidity;
        $this->windSpeed = $windSpeed;
    }

    /**
     * @return string
     */
    public function getTemp(): string
    {
        return $this->temp;
    }

    /**
     * @return string
     */
    public function getPressure(): string
    {
        return $this->pressure;
    }

    /**
     * @return string
     */
    public function getHumidity(): string
    {
        return $this->humidity;
    }

    /**
     * @return string
     */
    public function getWindSpeed(): string
    {
        return $this->windSpeed;
    }
}
