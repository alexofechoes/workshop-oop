<?php

namespace Php\Package\Common;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class HttpClient
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $url;

    /**
     * HttpClient constructor.
     * @param string $url
     * @param null|ClientInterface $client
     */
    public function __construct(string $url, ?ClientInterface $client)
    {
        $this->url = $url;
        $this->client = $client ?? new Client();
    }

    /**
     * @param string $ip
     * @return string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $ip): string
    {
        $response = $this->client->request('GET', $this->getUrl($ip));
        return (string)$response->getBody();
    }

    /**
     * @param string $ip
     *
     * @return string
     */
    private function getUrl(string $ip): string
    {
        return "{$this->url}{$ip}";
    }
}
