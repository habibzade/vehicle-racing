<?php

namespace App\Factory;

use App\Interfaces\UnitConverterInterface;

class KilometersPerHourConverter implements UnitConverterInterface
{
    private const METERS_PER_KILOMETER = 1000;
    private const SECONDS_PER_HOUR     = 3600;

    /**
     * Convert speed from kilometers per hour to meters per second
     * 
     * @param int $speed
     * @return float
     */
    public function convert(int $speed): float
    {
        // Convert km/h to m/s
        return $speed * self::METERS_PER_KILOMETER / self::SECONDS_PER_HOUR;
    }
}
