<?php

namespace App\Models;

use App\Models\Abstract\AbstractJuicerComponent;
use App\Interfaces\ContainerInterface;
use App\Exceptions\JuicerException;
use App\Validators\JuicerValidator;

class FruitContainer implements ContainerInterface
{
    private float $currentVolume = 0;
    private int $fruitCount = 0;
    private float $capacity = 20.0;


    public function addFruit(Fruit $fruit): void
    {
        $newVolume = $this->capacity - $fruit->getVolume() / 2;
        JuicerValidator::validateContainerSpace($newVolume, $this->capacity);

        $this->capacity = $newVolume;
        $this->fruitCount++;
    }

    public function getFruitCount(): int
    {
        return $this->fruitCount;
    }

    public function getRemainingCapacity(): float
    {
        return $this->capacity - $this->currentVolume;
    }

    public function clear(): void
    {
        $this->currentVolume = 0;
        $this->fruitCount = 0;
        $this->capacity = 20.0;
    }
    public function getCurrentVolume(): float
    {
        return $this->capacity;
    }

    public function getCapacity(): float
    {
        return $this->capacity;
    }

    public function toString(): string
    {
        return "Container capacity: {$this->capacity}L, fruits: {$this->fruitCount}, remaining capacity: {$this->getRemainingCapacity()}L";
    }

    public function isFull(float $fruitVolume): bool
    {
        if ($this->capacity - $fruitVolume < 0) {
            return true;
        }
        return false;
    }
}
