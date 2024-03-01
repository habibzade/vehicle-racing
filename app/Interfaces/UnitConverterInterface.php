<?php

namespace App\Interfaces;

interface UnitConverterInterface
{
    public function convert(int $speed): float;
}
