<?php

namespace Php\Package\Tests\IpGeo;

use Php\Package\Weather\MetaWeather;
use Php\Package\Weather\OtherWeather;
use Php\Package\Weather\WeatherServiceFactory;
use PHPUnit\Framework\TestCase;

class WeatherServiceFactoryTest extends TestCase
{
    public function testRequestData()
    {
        $this->assertInstanceOf(MetaWeather::class, WeatherServiceFactory::createService('metaweather'));
        $this->assertInstanceOf(OtherWeather::class, WeatherServiceFactory::createService('otherweather'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUnsupportedService()
    {
        WeatherServiceFactory::createService('unsupportedService');
    }
}
