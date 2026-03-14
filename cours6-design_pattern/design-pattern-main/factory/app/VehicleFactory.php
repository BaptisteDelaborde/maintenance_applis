<?php

namespace App;

use App\Entity\Bicycle;
use App\Entity\Car;
use App\Entity\Truck;

class VehicleFactory
{
    public function create(string $type): Vehicle
    {
        return match (strtolower($type)) {
            'bicycle', 'velo' => new Bicycle(0.00, 'muscle'),
            'car', 'voiture' => new Car(0.15, 'essence'),
            'truck', 'camion' => new Truck(0.30, 'diesel'),
            default => throw new \InvalidArgumentException("Type inconnu : $type"),
        };
    }

    public function createForDelivery(int $distanceKm, float $weightKg): Vehicle
    {
        if ($weightKg > 200) {
            return new Truck(0.30, 'diesel');
        }
        if ($weightKg > 20 || $distanceKm >= 20) {
            return new Car(0.15, 'essence');
        }
        return new Bicycle(0.05, 'muscle');
    }
}
