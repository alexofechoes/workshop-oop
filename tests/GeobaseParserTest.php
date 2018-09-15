<?php

namespace Php\Package\Tests;

use Php\Package\Dto\GeobaseData;
use PHPUnit\Framework\TestCase;
use Php\Package\GeobaseParser;

class GeobaseParserTest extends TestCase
{
    private $parser;

    public function setUp()
    {
        $this->parser = new GeobaseParser();
    }


    public function testParse()
    {
        $xml = <<<XML
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

        $geobaseData = $this->parser->parse($xml);

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
     * @expectedExceptionMessage Not found
     */
    public function testParseNotFound()
    {
        $xml = <<<XML
<ip-answer>
<ip value="1.2.3.4">
<message>Not found</message>
</ip>
</ip-answer>
XML;

        $this->parser->parse($xml);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testParseWithEmptyXml()
    {
        $xml = '';

        $this->parser->parse($xml);
    }
}
