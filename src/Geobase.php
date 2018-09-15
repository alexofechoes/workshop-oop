<?php

namespace Php\Package;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use League\Pipeline\Pipeline;
use Php\Package\Dto\GeobaseData;
use Php\Package\Exception\GeobaseException;

class Geobase
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var GeobaseParser
     */
    private $parser;

    public function __construct($httpClient, $parser)
    {
        $this->httpClient = $httpClient;
        $this->parser = $parser;
    }

    /**
     * @param $ip
     * @return GeobaseData
     *
     * @throws GeobaseException
     */
    public function requestData($ip): GeobaseData
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new GeobaseException('Invalid ip');
        }

        try {
            $pipeline = (new Pipeline)
                ->pipe($this->httpClient)
                ->pipe($this->parser);

            return $pipeline($ip);
        } catch (GuzzleException|Exception $exception) {
            throw new GeobaseException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}