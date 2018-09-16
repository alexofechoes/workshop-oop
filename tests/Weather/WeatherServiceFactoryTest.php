<?php

namespace Php\Package\Tests\IpGeo;

use Php\Package\Weather\MetaWeather;
use Php\Package\Weather\OtherWeather;
use Php\Package\Weather\WeatherServiceFactory;
use PHPUnit\Framework\TestCase;

class WeatherServiceFactoryTest extends TestCase
{
    /**
     * @var WeatherServiceFactory
     */
    private $serviceFactory;

    public function setUp()
    {
        $this->serviceFactory = new WeatherServiceFactory([
            'meta-weather' => MetaWeather::class,
            'other-weather' => OtherWeather::class
        ]);
    }

    public function testRequestData()
    {
        $this->assertInstanceOf(MetaWeather::class, $this->serviceFactory->createService('meta-weather'));
        $this->assertInstanceOf(OtherWeather::class, $this->serviceFactory->createService('other-weather'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUnsupportedService()
    {
        $this->serviceFactory->createService('unsupported-service-weather');
    }
}
