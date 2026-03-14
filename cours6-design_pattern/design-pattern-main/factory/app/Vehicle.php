<?php

namespace App;

interface Vehicle
{
    public function getCostPerKm(): float;

    public function getFuelType(): string;
}
