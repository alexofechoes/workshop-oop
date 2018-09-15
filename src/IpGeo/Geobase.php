<?php

namespace Php\Package\IpGeo;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Php\Package\IpGeo\Exception\GeoException;
use SimpleXMLElement;

class Geobase
{
    const URL = 'http://ipgeobase.ru:7020/geo?ip=';

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
     * @param $ip
     * @return GeoData
     *
     * @throws GeoException
     */
    public function getData($ip): GeoData
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new GeoException('Invalid ip');
        }

        try {
            $response = $this->httpClient->request('GET', self::URL . $ip);
            return $this->parse($response->getBody());
        } catch (GuzzleException|Exception $exception) {
            throw new GeoException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string $xml
     * @return GeoData
     *
     * @throws GeoException
     */
    private function parse(string $xml): GeoData
    {
        $simpleXMLElement = new SimpleXMLElement($xml);
        $attributes = $simpleXMLElement->ip;

        if (isset($attributes->message)) {
            throw new GeoException($simpleXMLElement->ip->message);
        }

        return new GeoData(
            $attributes->country,
            $attributes->city,
            $attributes->region,
            $attributes->lat,
            $attributes->lng
        );
    }
}
