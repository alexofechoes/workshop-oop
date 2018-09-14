<?php

namespace Php\Package;

use Php\Package\Dto\GeobaseData;
use Php\Package\Exception\GeobaseException;
use SimpleXMLElement;

class Parser
{
    /**
     * @param string $xml
     * @return GeobaseData
     * @throws GeobaseException
     */
    public function parse(string $xml): GeobaseData
    {
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