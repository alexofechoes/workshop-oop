<?php

namespace Php\Package\Weather;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Php\Package\Weather\Exception\WeatherException;

class OtherWeather
{
    const URL = 'https://www.metaweather.com/api/location/';

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @param ClientInterface|null $client
     */
    public function __construct(?ClientInterface $client = null)
    {
        $this->httpClient = $client ?? new Client();
    }

    /**
     * @param string $city
     * @return WeatherData
     *
     * @throws WeatherException
     * @throw InvalidArgumentException
     */
    public function getData(string $city): WeatherData
    {
        if (!$city === '') {
            throw new \InvalidArgumentException('City can\'t be blank');
        }

        try {
            $response = $this->httpClient->request('GET', $this->getCityUrl($city));
        } catch (GuzzleException|\Exception $e) {
            throw new WeatherException($e->getMessage());
        }

        return $this->parse($response->getBody());
    }

    /**
     * @param string $json
     * @return WeatherData
     */
    private function parse(string $json): WeatherData
    {
        $weatherData = \json_decode($json, true);
        $weather = $weatherData["consolidated_weather"][0];

        return new WeatherData(
            $weather['the_temp'],
            $weather['air_pressure'],
            $weather['humidity'],
            $weather['wind_speed']
        );
    }

    /**
     * @param string $city
     * @return string
     *
     * @throws WeatherException
     * @throws GuzzleException
     */
    private function getCityUrl(string $city): string
    {
        return self::URL . $this->getCityId($city);
    }

    /**
     * @param $city
     * @return mixed
     *
     * @throws WeatherException
     * @throws GuzzleException
     */
    private function getCityId($city)
    {
        $response = $this->httpClient->request('GET', 'https://www.metaweather.com/api/location/search/?query=' . $city);

        $json = json_decode($response->getBody());
        if (!$json) {
            throw new WeatherException('City not found');
        }

        return $json[0]->woeid;
    }
}
