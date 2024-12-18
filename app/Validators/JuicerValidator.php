<?php

namespace App\Validators;

use App\Models\Fruit;
use App\Models\Apple;
use App\Exceptions\JuicerException;

/**
 * Class JuicerValidator
 * 
 * Provides validation methods for juicer components.
 * Ensures proper capacity and space management in the juicer.
 * 
 * @package App\Validators
 */
class JuicerValidator
{
    /**
     * Validates juicer component capacity
     * 
     * Ensures that a juicer component has a valid positive capacity.
     * Used for both container and strainer components.
     *
     * @param float $capacity The capacity to validate
     * @throws JuicerException When capacity is not positive
     */
    public static function validateCapacity(float $capacity): void
    {
        if ($capacity <= 0) {
            throw JuicerException::invalidCapacity($capacity);
        }
    }

    /**
     * Validates container space for new fruit
     * 
     * Ensures that there is enough space in the container for a new fruit.
     * Checks if adding the new volume would exceed the container's capacity.
     *
     * @param float $newVolume The volume after adding new fruit
     * @param float $capacity  The total capacity of the container
     * @throws JuicerException When new volume would exceed capacity
     */
    public static function validateContainerSpace(float $newVolume, float $capacity): void
    {
        if ($newVolume > $capacity) {
            throw JuicerException::containerFull($capacity);
        }
    }
} 