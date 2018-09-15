<?php

namespace Php\Package\IpApi;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Php\Package\Common\HttpClient;
use Php\Package\Dto\GeoData;
use Php\Package\IpApi\Exception\IpApiException;

class IpApi
{
    const URL = 'http://ip-api.com/json/';

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @param ClientInterface|null $client
     */
    public function __construct(?ClientInterface $client = null)
    {
        $this->httpClient = new HttpClient(self::URL, $client);
        $this->parser = new Parser();
    }

    /**
     * @param $ip
     * @return GeoData
     *
     * @throws IpApiException
     */
    public function getData($ip): GeoData
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new IpApiException('Invalid ip');
        }

        try {
            $rawData = $this->httpClient->request($ip);
            return $this->parser->parse($rawData);
        } catch (GuzzleException|Exception $exception) {
            throw new IpApiException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
