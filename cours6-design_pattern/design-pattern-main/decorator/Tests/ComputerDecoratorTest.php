<?php

namespace Test;

use PHPUnit\Framework\TestCase;

use App\Laptop;
use App\GPUDecorator;
use App\OLEDScreenDecorator;

class ComputerDecoratorTest extends TestCase
{
    public function testBasicLaptop()
    {
        $laptop = new Laptop();

        $this->assertSame(400, $laptop->getPrice());
        $this->assertSame("A laptop computer", $laptop->getDescription());
    }

    public function testLaptopWithGPU()
    {
        $laptop = new Laptop();
        $laptopWithGpu = new GPUDecorator($laptop);

        $this->assertSame(500, $laptopWithGpu->getPrice());
        $this->assertSame("A laptop computer, GPU", $laptopWithGpu->getDescription());
    }

    public function testLaptopWithOLEDScreen()
    {
        $laptop = new Laptop();
        $laptopWithOled = new OLEDScreenDecorator($laptop);

        $this->assertSame(550, $laptopWithOled->getPrice());
        $this->assertSame("A laptop computer, OLED screen", $laptopWithOled->getDescription());
    }

    public function testLaptopWithGPUAndOLEDScreen()
    {
        $laptop = new Laptop();
        $laptopWithGpuAndOled = new OLEDScreenDecorator(new GPUDecorator($laptop));

        $this->assertSame(650, $laptopWithGpuAndOled->getPrice());
        $this->assertSame("A laptop computer, GPU, OLED screen", $laptopWithGpuAndOled->getDescription());
    }
}