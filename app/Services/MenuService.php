<?php

namespace App\Services;

use Exception;
use RuntimeException;

require_once __DIR__ . '/../../vendor/wp-cli/php-cli-tools/examples/common.php';

class MenuService
{
    const FILE_PATH = __DIR__ . '/../../assets/vehicles.json';

    /**
     * Get vehicles from the input file
     *
     * @return array
     */
    public function getVehicles(int $number_players = 2): array
    {
        $vehicles = $this->loadVehicles();
        if ($vehicles) {
            $menu     = $this->generateMenu($vehicles);

            $players = [];
            for ($i = 1; $i <= $number_players; $i++) {
                $input = \cli\menu($menu, null, "Choose player {$i}");
    
                $players[] = $vehicles[$input];
            }
    
            return $players;
        }

        throw new RuntimeException("The input file is empty!");
    }

    /**
    * Load vehicles from the vehicles.json file
    *
    * @return array
    */
    private function loadVehicles(): array
    {
        try {
            $filePath = self::FILE_PATH;
            if (! file_exists($filePath)) {
                throw new RuntimeException("The input file is not found at {$filePath}");
            }

            $vehicles = json_decode(file_get_contents(self::FILE_PATH), true);
            return is_array($vehicles) ? $vehicles : [];

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Generate a menu based on the parameter
     *
     * @param array $vehicles
     * @return array
     */
    private function generateMenu(array $vehicles): array
    {
        $menu = [];
        foreach ($vehicles as $vehicle) {
            $menu[] = $vehicle['name'];
        }

        return $menu;
    }
}
