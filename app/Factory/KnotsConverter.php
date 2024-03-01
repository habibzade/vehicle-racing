<?php

namespace App\Factory;
use App\Interfaces\UnitConverterInterface;

class KnotsConverter implements UnitConverterInterface
{
    private const METERS_PER_NAUTICAL_MILE = 1852;
    private const SECONDS_PER_HOUR         = 3600;

    public function convert(int $speed): float
    {
        // Convert knots to m/s (1 knot = 1852 m/h)
        return $speed * self::METERS_PER_NAUTICAL_MILE / self::SECONDS_PER_HOUR;
    }
}