<?php

namespace Php\Package\Geobase;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use League\Pipeline\Pipeline as Pipe;
use Php\Package\Dto\GeoData;
use Php\Package\Geobase\Exception\GeobaseException;
use Php\Package\Common\HttpClient;

class Geobase
{
    const URL = 'http://ipgeobase.ru:7020/geo?ip=';

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Parser
     */
    private $parser;

    public function __construct(ClientInterface $client)
    {
        $this->httpClient = new HttpClient($client, self::URL);
        $this->parser = new Parser();
    }

    /**
     * @param $ip
     * @return GeoData
     *
     * @throws GeobaseException
     */
    public function getData($ip): GeoData
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new GeobaseException('Invalid ip');
        }

        try {
            $pipeline = (new Pipe)
                ->pipe($this->httpClient)
                ->pipe($this->parser);

            return $pipeline($ip);
        } catch (GuzzleException|Exception $exception) {
            throw new GeobaseException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}