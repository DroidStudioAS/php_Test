<?php

namespace App\Interfaces;

use App\Models\Fruit;

interface JuicerInterface
{
    public function addFruit(Fruit $fruit): void;
    public function getFruitCount(): int;
    public function getContainerCapacity(): float;
    public function getRemainingCapacity(): float;
    public function getTotalJuice(): float;
    public function squeeze(): float;
    public function clear(): void;
    public function toString(): string;
} 