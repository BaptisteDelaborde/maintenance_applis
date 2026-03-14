<?php

namespace App\Entity;

use App\Vehicle;
// Exemple du cours Factory
class Bicycle implements Vehicle
{
    private float $costPerKm;
    private string $fuelType;

    public function __construct(float $costPerKm, string $fuelType)
    {
        $this->costPerKm = $costPerKm;
        $this->fuelType = $fuelType;
    }

    public function getCostPerKm(): float
    {
        return $this->costPerKm;
    }

    public function getFuelType(): string
    {
        return $this->fuelType;
    }
}