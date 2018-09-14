<?php

namespace Php\Package;

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
    private $method;

    /**
     * @var string
     */
    private $url;

    /**
     * HttpClient constructor.
     * @param ClientInterface $client
     * @param string $method
     * @param string $url
     */
    public function __construct(ClientInterface $client, string $method, string $url)
    {
        $this->client = $client;
        $this->method = $method;
        $this->url = $url;
    }

    /**
     * @param string $ip
     * @return string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $ip): string
    {
        $response = $this->client->request($this->method, $this->getUrl($ip));
        return (string)$response->getBody();
    }

    /**
     * @param string $ip
     *
     * @return string
     */
    private function getUrl(string $ip) : string
    {
        return "{$this->url}{$ip}";
    }
}