<?php

namespace Php\Package\Tests;

use Php\Package\Dto\GeobaseData;
use Php\Package\Geobase;
use Php\Package\HttpClient;
use \PHPUnit\Framework\TestCase;
use \Php\Package\GeobaseParser;

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

        $geobaseData = $this->createGeobase($xml)->requestData('91.76.0.2');

        $this->assertInstanceOf(GeobaseData::class, $geobaseData);
        $this->assertEquals('91.76.0.0 - 91.79.255.255', $geobaseData->getInetnum());
        $this->assertEquals('RU', $geobaseData->getCountry());
        $this->assertEquals('Москва', $geobaseData->getCity());
        $this->assertEquals('Москва', $geobaseData->getRegion());
        $this->assertEquals('Центральный федеральный округ', $geobaseData->getDistrict());
        $this->assertEquals('55.755787', $geobaseData->getLat());
        $this->assertEquals('37.617634', $geobaseData->getLng());
    }

    /**
     * @expectedException \Php\Package\Exception\GeobaseException
     * @expectedExceptionMessage Invalid ip
     */
    public function testRequestDataInvalidIp()
    {
        $this->createGeobase('')->requestData('1.257.3288.338');
    }

    /**
     * @expectedException \Php\Package\Exception\GeobaseException
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

        $this->createGeobase($xml)->requestData('91.76.0.2');
    }

    /**
     * @param string $xml
     * @return Geobase
     * @throws \ReflectionException
     */
    public function createGeobase(string $xml)
    {
        $httpClient = $this->createMock(HttpClient::class);
        $httpClient
            ->method('request')
            ->willReturn($xml);

        $parser = new GeobaseParser();

        $geobase = new Geobase($httpClient, $parser);

        return $geobase;
    }
}
