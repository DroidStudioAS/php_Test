<?php

namespace App\Models;

use App\Models\Abstract\AbstractJuicerComponent;
use App\Interfaces\ContainerInterface;
use App\Exceptions\JuicerException;
use App\Validators\JuicerValidator;

/**
 * Class FruitContainer
 * 
 * Represents a container that holds fruits in the juicer.
 * Manages fruit storage and capacity tracking.
 * 
 * @package App\Models
 * @implements ContainerInterface
 */
class FruitContainer implements ContainerInterface
{
    /** @var float Current volume of juice in the container */
    private float $currentVolume = 0;

    /** @var int Number of fruits currently in the container */
    private int $fruitCount = 0;

    /** @var float Maximum capacity of the container in liters */
    private float $capacity = 20.0;

    /**
     * Add a fruit to the container
     * 
     * @param Fruit $fruit The fruit to add to the container
     * @throws JuicerException When container doesn't have enough space
     * @return void
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
     * 
     * @return int The count of fruits
     */
    public function getFruitCount(): int
    {
        return $this->fruitCount;
    }

    /**
     * Get the remaining capacity of the container
     * 
     * @return float The remaining capacity in liters
     */
    public function getRemainingCapacity(): float
    {
        return $this->capacity - $this->currentVolume;
    }

    /**
     * Clear the container of all fruits and reset capacity
     * 
     * @return void
     */
    public function clear(): void
    {
        $this->currentVolume = 0;
        $this->fruitCount = 0;
        $this->capacity = 20.0;
    }

    /**
     * Get the current volume of the container
     * 
     * @return float The current volume in liters
     */
    public function getCurrentVolume(): float
    {
        return $this->capacity;
    }

    /**
     * Get the total capacity of the container
     * 
     * @return float The total capacity in liters
     */
    public function getCapacity(): float
    {
        return $this->capacity;
    }

    /**
     * Get a string representation of the container state
     * 
     * @return string Description of container including capacity, fruit count, and remaining capacity
     */
    public function toString(): string
    {
        return "Container capacity: {$this->capacity}L, fruits: {$this->fruitCount}, remaining capacity: {$this->getRemainingCapacity()}L";
    }

    /**
     * Check if the container is full for a given fruit volume
     * 
     * @param float $fruitVolume The volume of fruit to check
     * @return bool True if container would be full with this fruit, false otherwise
     */
    public function isFull(float $fruitVolume): bool
    {
        if (($this->capacity - ($fruitVolume /2)) < 0) {
            return true;
        }
        return false;
    }
}
