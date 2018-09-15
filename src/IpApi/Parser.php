<?php

namespace Php\Package\IpApi;

use Php\Package\Dto\GeoData;
use Php\Package\IpApi\Exception\IpApiException;

class Parser
{
    /**
     * @param string $json
     * @return GeoData
     * @throws IpApiException
     */
    public function parse(string $json): GeoData
    {
        if ($json === '') {
            throw new \InvalidArgumentException('Json can\'t be blank');
        }

        $attributes = \json_decode($json, false);

        if (isset($attributes->message)) {
            throw new IpApiException($attributes->message);
        }

        return new GeoData(
            $attributes->country,
            $attributes->city,
            $attributes->region,
            $attributes->lat,
            $attributes->lon
        );
    }
}
