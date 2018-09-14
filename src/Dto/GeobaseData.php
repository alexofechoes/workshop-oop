<?php

namespace Php\Package\Dto;

class GeobaseData
{
    private $inetnum;
    private $country;
    private $city;
    private $region;
    private $district;
    private $lat;
    private $lng;

    /**
     * GeobaseData constructor.
     * @param $inetnum
     * @param $country
     * @param $city
     * @param $region
     * @param $district
     * @param $lat
     * @param $lng
     */
    public function __construct(
        string $inetnum,
        string $country,
        string $city,
        string $region,
        string $district,
        string $lat,
        string $lng
    ) {
        $this->inetnum = $inetnum;
        $this->country = $country;
        $this->city = $city;
        $this->region = $region;
        $this->district = $district;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    /**
     * @return string
     */
    public function getInetnum(): string
    {
        return $this->inetnum;
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
    public function getDistrict(): string
    {
        return $this->district;
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