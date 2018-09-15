<?php

namespace Php\Package\Geobase\Tests;

use GuzzleHttp\ClientInterface;
use Php\Package\IpApi;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class IpApiTest extends TestCase
{
    public function testRequestData()
    {
        $json = <<<JSON
{
    "as": "AS8359 MTS PJSC",
    "city": "Moscow",
    "country": "Russia",
    "countryCode": "RU",
    "isp": "MTS PJSC",
    "lat": 55.7522,
    "lon": 37.6156,
    "org": "MTS Broadband",
    "query": "91.76.0.2",
    "region": "MOW",
    "regionName": "Moscow",
    "status": "success",
    "timezone": "Europe/Moscow",
    "zip": "121096"
}
JSON;

        $ipApiData = $this->createIpApi($json)->getData('91.76.0.2');

        $this->assertEquals('Russia', $ipApiData->getCountry());
        $this->assertEquals('Moscow', $ipApiData->getCity());
        $this->assertEquals('MOW', $ipApiData->getRegion());
        $this->assertEquals('55.7522', $ipApiData->getLat());
        $this->assertEquals('37.6156', $ipApiData->getLng());
    }

    /**
     * @expectedException \Php\Package\Exception\GeoException
     * @expectedExceptionMessage reserved range
     */
    public function testRequestDataNotFound()
    {
        $json = <<<JSON
{
    "message": "reserved range",
    "query": "127.0.0.1",
    "status": "fail"
}
JSON;

        $this->createIpApi($json)->getData('91.76.0.2');
    }

    /**
     * @param string $body
     * @return IpApi
     *
     * @throws \ReflectionException
     */
    private function createIpApi(string $body)
    {
        return new IpApi($this->createHttpClient($body));
    }

    /**
     * @param string $body
     * @return ClientInterface
     *
     * @throws \ReflectionException
     */
    private function createHttpClient(string $body): ClientInterface
    {
        $httpResponse = $this->createMock(ResponseInterface::class);
        $httpResponse
            ->method('getBody')
            ->willReturn($body);

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
            ->method('request')
            ->willReturn($httpResponse);

        return $httpClient;
    }
}
