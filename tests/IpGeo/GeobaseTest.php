<?php

namespace Php\Package\Tests\IpGeo;

use GuzzleHttp\ClientInterface;
use Php\Package\IpGeo\Geobase;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class GeobaseTest extends TestCase
{
    public function testRequestData()
    {
        $xml = $xml = <<<XML
<ip-answer>
<ip value="91.78.218.99">
<inetnum>91.76.0.0 - 91.79.255.255</inetnum>
<country>RU</country>
<city>Москва</city>
<region>Москва</region>
<district>Центральный федеральный округ</district>
<lat>55.755787</lat>
<lng>37.617634</lng>
</ip>
</ip-answer>
XML;

        $geobaseData = $this->createGeobase($xml)->getData('91.76.0.2');

        $this->assertEquals('RU', $geobaseData->getCountry());
        $this->assertEquals('Москва', $geobaseData->getCity());
        $this->assertEquals('Москва', $geobaseData->getRegion());
        $this->assertEquals('55.755787', $geobaseData->getLat());
        $this->assertEquals('37.617634', $geobaseData->getLng());
    }

    /**
     * @expectedException \Php\Package\IpGeo\Exception\GeoException
     * @expectedExceptionMessage Invalid ip
     */
    public function testRequestDataInvalidIp()
    {
        $this->createGeobase('')->getData('1.257.3288.338');
    }

    /**
     * @expectedException \Php\Package\IpGeo\Exception\GeoException
     * @expectedExceptionMessage Not found
     */
    public function testRequestDataNotFound()
    {
        $xml = <<<XML
<ip-answer>
<ip value="1.2.3.4">
<message>Not found</message>
</ip>
</ip-answer>
XML;

        $this->createGeobase($xml)->getData('91.76.0.2');
    }

    /**
     * @param string $body
     * @return Geobase
     * @throws \ReflectionException
     */
    public function createGeobase(string $body)
    {
        return new Geobase($this->createHttpClient($body));
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
