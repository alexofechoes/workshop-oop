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
     *
     * @throws GeobaseException
     */
    public function parse(string $xml): GeoData
    {
        $simpleXMLElement = new SimpleXMLElement($xml);
        $attributes = $simpleXMLElement->ip;

        if (isset($attributes->message)) {
            throw new GeobaseException($simpleXMLElement->ip->message);
        }

        return new GeoData(
            $attributes->country,
            $attributes->city,
            $attributes->region,
            $attributes->lat,
            $attributes->lng
        );
    }
}
