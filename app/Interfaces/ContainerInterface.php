<?php

namespace App\Interfaces;

use App\Models\Fruit;

interface ContainerInterface extends JuicerComponentInterface
{
    public function addFruit(Fruit $fruit): void;
    public function getFruitCount(): int;
    public function getRemainingCapacity(): float;
} 