<?php

namespace Php\Package\Geobase;

use Php\Package\Dto\GeoData;
use Php\Package\Geobase\Exception\GeobaseException;
use SimpleXMLElement;

class Parser
{
    /**
     * @param string $xml
     * @return GeoData
     * @throws GeobaseException
     */
    public function parse(string $xml): GeoData
    {
        if ($xml === '') {
            throw new \InvalidArgumentException('Xml can\'t be blank');
        }

        $simpleXMLElement = new SimpleXMLElement($xml);

        if (isset($simpleXMLElement->ip->message)) {
            throw new GeobaseException($simpleXMLElement->ip->message);
        }

        $attributes = $simpleXMLElement->ip;

        return new GeoData(
            $attributes->country,
            $attributes->city,
            $attributes->region,
            $attributes->lat,
            $attributes->lng
        );
    }
}
