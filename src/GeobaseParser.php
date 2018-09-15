<?php

namespace Php\Package;

use League\Pipeline\StageInterface;
use Php\Package\Dto\GeobaseData;
use Php\Package\Exception\GeobaseException;
use SimpleXMLElement;

class GeobaseParser implements StageInterface
{
    /**
     * @param string $payload
     * @return GeobaseData
     *
     * @throws GeobaseException
     */
    public function __invoke($payload): GeobaseData
    {
        return $this->parse($payload);
    }

    /**
     * @param string $xml
     * @return GeobaseData
     * @throws GeobaseException
     */
    public function parse(string $xml): GeobaseData
    {
        if ($xml === '') {
            throw new \InvalidArgumentException('Xml can\'t be blank');
        }

        $simpleXMLElement = new SimpleXMLElement($xml);

        if (isset($simpleXMLElement->ip->message)) {
            throw new GeobaseException($simpleXMLElement->ip->message);
        }

        $attributes = $simpleXMLElement->ip;

        return new GeobaseData(
            $attributes->inetnum,
            $attributes->country,
            $attributes->city,
            $attributes->region,
            $attributes->district,
            $attributes->lat,
            $attributes->lng
        );
    }
}