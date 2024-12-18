<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\FruitInterface;
use App\Exceptions\FruitException;
use App\Validators\FruitValidator;

/**
 * Class Apple
 * 
 * Represents an Apple fruit which extends the base Fruit class.
 * Adds the capability to track if the apple is rotten.
 * 
 * @package App\Models
 * @extends Fruit
 */
class Apple extends Fruit implements FruitInterface
{
    /** @var bool Indicates whether the apple is rotten */
    private bool $isRotten;

    /**
     * Constructs a new Apple instance
     * 
     * @param string $color    The color of the apple
     * @param float  $volume   The volume of the apple in liters
     * @param bool   $isRotten Whether the apple is rotten
     * @throws FruitException When validation fails for color, volume, or rotten state
     */
    public function __construct(string $color, float $volume, bool $isRotten)
    {
        try {
            FruitValidator::validateApple($color, $volume, $isRotten);
            parent::__construct($color, $volume);
            $this->isRotten = $isRotten;
        } catch (FruitException $e) {
            throw $e;
        }
    }

    /**
     * Check if the apple is rotten
     * 
     * @return bool True if the apple is rotten, false otherwise
     */
    public function isRotten(): bool
    {
        return $this->isRotten;
    }

    /**
     * Get a string representation of the apple
     * 
     * @return string Description of the apple including color, volume, and rotten state
     */
    public function toString(): string
    {
        return "Apple is {$this->getColor()} and of {$this->getVolume()}l volume. It is rotten: " . 
            ($this->isRotten ? 'true' : 'false');
    }
}


