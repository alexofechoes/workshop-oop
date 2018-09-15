<?php

namespace Php\Package\Tests;

use Php\Package\Dto\GeoData;
use Php\Package\Geobase\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    private $parser;

    public function setUp()
    {
        $this->parser = new Parser();
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

        $geoData = $this->parser->parse($xml);

        $this->assertInstanceOf(GeoData::class, $geoData);
        $this->assertEquals('RU', $geoData->getCountry());
        $this->assertEquals('Москва', $geoData->getCity());
        $this->assertEquals('Москва', $geoData->getRegion());
        $this->assertEquals('55.755787', $geoData->getLat());
        $this->assertEquals('37.617634', $geoData->getLng());
    }

    /**
     * @expectedException \Php\Package\Geobase\Exception\GeobaseException
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
