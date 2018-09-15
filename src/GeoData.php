<?php

namespace Php\Package;

class GeoData
{
    private $country;
    private $city;
    private $region;
    private $lat;
    private $lng;

    /**
     * @param $country
     * @param $city
     * @param $region
     * @param $lat
     * @param $lng
     */
    public function __construct(
        string $country,
        string $city,
        string $region,
        string $lat,
        string $lng
    )
    {
        $this->country = $country;
        $this->city = $city;
        $this->region = $region;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @return string
     */
    public function getLat(): string
    {
        return $this->lat;
    }

    /**
     * @return string
     */
    public function getLng(): string
    {
        return $this->lng;
    }
}
