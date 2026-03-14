<?php
require __DIR__ . '/../vendor/autoload.php';

$factory = new App\VehicleFactory();

$bicycle = $factory->create('bicycle');
$car = $factory->create('car');
$truck = $factory->create('truck');

echo "Vélo : " . $bicycle->getFuelType() . ", " . $bicycle->getCostPerKm() . " €/km\n";
echo "Voiture : " . $car->getFuelType() . ", " . $car->getCostPerKm() . " €/km\n";
echo "Camion : " . $truck->getFuelType() . ", " . $truck->getCostPerKm() . " €/km\n";