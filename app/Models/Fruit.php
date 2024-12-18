<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\FruitInterface;
use App\Exceptions\FruitException;
use App\Validators\FruitValidator;

/**
 * Class Fruit
 * 
 * Base class representing a fruit with basic properties like color and volume.
 * Implements the FruitInterface for consistent fruit behavior across the system.
 * 
 * @package App\Models
 */
class Fruit implements FruitInterface
{
    /** @var string The color of the fruit */
    private string $color;

    /** @var float The volume of the fruit in liters */
    private float $volume;

    /**
     * Constructs a new Fruit instance
     * 
     * @param string $color  The color of the fruit
     * @param float $volume The volume of the fruit in liters
     * @throws FruitException When validation fails for color or volume
     */
    public function __construct(string $color, float $volume)
    {
        try {
            FruitValidator::validate($color, $volume);
            
            $this->color = $color;
            $this->volume = $volume;
        } catch (FruitException $e) {
            throw $e; // Re-throw the exception after any necessary logging or handling
        }
    }

    /**
     * Get the color of the fruit
     * 
     * @return string The fruit's color
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Get the volume of the fruit
     * 
     * @return float The fruit's volume in liters
     */
    public function getVolume(): float
    {
        return $this->volume;
    }

    /**
     * Get a string representation of the fruit
     * 
     * @return string Description of the fruit including color and volume
     */
    public function toString(): string
    {
        return "Fruit is {$this->color} and of {$this->volume}l volume";
    }

    /**
     * Calculate the amount of juice that can be extracted from the fruit
     * 
     * @return float The amount of juice in liters (50% of fruit volume)
     */
    public function getJuiceAmount(): float
    {
        return $this->volume * 0.5; // 50% of fruit volume
    }
}
