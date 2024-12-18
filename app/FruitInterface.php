<?php

namespace App;

/**
 * Interface FruitInterface
 * 
 * Defines the contract for all fruit objects in the system.
 * Ensures consistent behavior across different types of fruits.
 * 
 * @package App
 */
interface FruitInterface
{
    /**
     * Get the color of the fruit
     * 
     * @return string The fruit's color
     */
    public function getColor(): string;

    /**
     * Get the volume of the fruit
     * 
     * @return float The fruit's volume in liters
     */
    public function getVolume(): float;

    /**
     * Get a string representation of the fruit
     * 
     * @return string Description of the fruit's properties
     */
    public function toString(): string;

    /**
     * Calculate the amount of juice that can be extracted from the fruit
     * 
     * @return float The amount of juice in liters
     */
    public function getJuiceAmount(): float;
}