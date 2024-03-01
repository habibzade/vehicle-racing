<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\MenuService;
use App\Controllers\RaceController;

$menu = new MenuService();
$race = new RaceController($menu->getVehicles());

$race->competition();
