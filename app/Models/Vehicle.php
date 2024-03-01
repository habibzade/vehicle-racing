<?php

namespace App\Models;

use App\Interfaces\UnitConverterInterface;

class Vehicle
{
    public function __construct(
        private string $name,
        private int $maxSpeed,
        private string $unit,
        private UnitConverterInterface $unitConverter,
    ) {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxSpeed(): int
    {
        return $this->maxSpeed;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * Calculate the time taken by the vehicle
     *
     * @param int $distance
     * @return float
     */
    public function calculateSpentTime(int $distance): int
    {
        $speedInMetersPerSecond = $this->unitConverter->convert($this->maxSpeed);

        return (int) ($distance / $speedInMetersPerSecond);
    }
}
