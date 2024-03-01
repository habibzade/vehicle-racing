<?php
namespace App\Controllers;

use App\Factory\KilometersPerHourConverter;
use App\Factory\KnotsConverter;
use App\Interfaces\UnitConverterInterface;
use App\Models\Vehicle;
use cli\progress\Bar;

class RaceController
{
    private const UNIT_KMH   = 'Km/h';
    private const UNIT_KTS   = 'Kts';
    private  const UNIT_KNOTS = 'knots';
    private const DISTANCE   = 10000;

    public function __construct(private array $vehicles)
    {

    }

    /**
     * Run competition between players
     * 
     * @return void <cli/line>
     */
    public function competition(): void
    {
        $raceVehicles = $this->initializeRaceVehicles();
        $this->notifyRacing();

        $this->displayResults($raceVehicles);
    }

    /**
     * Initialize race vehicles
     *
     * @return array
     */
    private function initializeRaceVehicles(): array
    {
        $raceVehicles = [];
        foreach ($this->vehicles as $key => $vehicle) {
            $raceVehicles[$key] = $this->createVehicle($vehicle);
        }
        return $raceVehicles;
    }

    /**
     * Create a Vehicle instance from vehicle data
     *
     * @param array $vehicleData
     * @return Vehicle
     */
    private function createVehicle(array $vehicleData): Vehicle
    {
        return new Vehicle(
            $vehicleData['name'],
            $vehicleData['maxSpeed'],
            $vehicleData['unit'],
            $this->convertUnit($vehicleData['unit'])
        );
    }

    /**
     * Convert unit to UnitConverterInterface
     *
     * @param string $unit
     * @return UnitConverterInterface
     * @throws \Exception
     */
    private function convertUnit(string $unit): UnitConverterInterface
    {
        return match ($unit) {
            self::UNIT_KMH                    => new KilometersPerHourConverter(),
            self::UNIT_KTS, self::UNIT_KNOTS  => new KnotsConverter(),
            default                           => throw new \Exception('Invalid Unit!'),
        };
    }

    /**
     * Display race results
     *
     * @param array $raceVehicles
     */
    private function displayResults(array $raceVehicles): void
    {
        $players = [];
        
        foreach ($raceVehicles as $vehicle) {
            $spentTime = $vehicle->calculateSpentTime(self::DISTANCE);
            $players[$vehicle->getName()] = $spentTime;
            
            $duration = gmdate("H:i:s", $spentTime);
            \cli\line("{$vehicle->getName()} Duration: {$duration}");
        }

        $winnerPlayer = array_search(min($players), $players);
        \cli\line("{$winnerPlayer} is the Winner :)");
    }

    /**
     * Notify the start of the race.
     * 
     * @return void
     */
    private function notifyRacing(): void
    {
        test_notify(new Bar('Racing ...', 500000));
    }
}
