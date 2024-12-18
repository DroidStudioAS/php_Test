<?php

namespace App\Models;

use App\Models\Abstract\AbstractJuicerComponent;
use App\Exceptions\JuicerException;
use App\Validators\JuicerValidator;

/**
 * Class FruitContainer
 * 
 * Represents a container that holds fruits in the juicer.
 * Manages fruit storage and capacity tracking.
 */
class FruitContainer
{
    private int $fruitCount = 0;
    private float $capacity = 20.0;

    /**
     * Add a fruit to the container
     */
    public function addFruit(Fruit $fruit): void
    {
        $newVolume = $this->capacity - $fruit->getVolume() / 2;
        JuicerValidator::validateContainerSpace($newVolume, $this->capacity);

        $this->capacity = $newVolume;
        $this->fruitCount++;
    }

    /**
     * Get the number of fruits in the container
     */
    public function getFruitCount(): int
    {
        return $this->fruitCount;
    }

    /**
     * Clear the container of all fruits and reset capacity
     */
    public function clear(): void
    {
        $this->fruitCount = 0;
        $this->capacity = 20.0;
    }

    /**
     * Get the current capacity of the container
     */
    public function getCapacity(): float
    {
        return $this->capacity;
    }

    /**
     * Check if the container is full for a given fruit volume
     */
    public function isFull(float $fruitVolume): bool
    {
        if (($this->capacity - ($fruitVolume /2)) < 0) {
            return true;
        }
        return false;
    }
}
