<?php

namespace App\Models;

use App\Exceptions\JuicerException;
use App\Validators\JuicerValidator;

class FruitContainer
{
    private float $capacity;
    private float $currentVolume = 0;
    private int $fruitCount = 0;

    public function __construct(float $capacity)
    {
        JuicerValidator::validateCapacity($capacity);
        $this->capacity = $capacity;
    }

    public function addFruit(Fruit $fruit): void
    {
        $newVolume = $this->currentVolume + $fruit->getVolume();
        JuicerValidator::validateContainerSpace($newVolume, $this->capacity);

        $this->currentVolume = $newVolume;
        $this->fruitCount++;
    }

    public function getFruitCount(): int
    {
        return $this->fruitCount;
    }

    public function getCapacity(): float
    {
        return $this->capacity;
    }

    public function getRemainingCapacity(): float
    {
        return $this->capacity - $this->currentVolume;
    }

    public function getCurrentVolume(): float
    {
        return $this->currentVolume;
    }

    public function clear(): void
    {
        $this->currentVolume = 0;
        $this->fruitCount = 0;
    }

    public function toString(): string
    {
        return "Container capacity: {$this->capacity}L, fruits: {$this->fruitCount}, remaining capacity: {$this->getRemainingCapacity()}L";
    }
}
