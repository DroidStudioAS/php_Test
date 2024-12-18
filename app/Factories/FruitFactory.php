<?php

namespace App\Factories;

use App\Models\Fruit;
use App\Models\Apple;

/**
 * Class FruitFactory
 * 
 * Factory class responsible for creating fruit instances.
 * Handles random generation of fruits and apples with various properties.
 * 
 * @package App\Factories
 */
class FruitFactory{

    /** @var array<string> List of possible fruit colors */
    private const COLORS = ["red", "green", "yellow", "blue", "purple", "orange", "pink", "brown", "gray", "black", "white"];
    
    /** @var array<float> Min and max volume for regular fruits [min, max] */
    private const MIN_MAX_VOLUME = [1.0, 3.0];
    
    /** @var array<float> Min and max volume for apples [min, max] */
    private const APPLE_MIN_MAX_VOLUME = [1.0, 5.0];
    
    /** @var float Probability of an apple being rotten (0.0 to 1.0) */
    private const ROTTEN_PROBABILITY = 0.2;

    /**
     * Generate a fruit instance based on type
     * 
     * @param string|null $type Type of fruit to generate ('apple' or null for random)
     * @return Fruit The generated fruit instance
     */
    public function generateFruit(string $type = null): Fruit
    {
        if ($type === null){
            return $this->generateRandomFruit();
        }
        return $this->generateApple();
    }

    /**
     * Generate a random fruit with random properties
     * 
     * @return Fruit A new random fruit instance
     */
    private function generateRandomFruit(): Fruit
    {
        return new Fruit(
            self::COLORS[array_rand(self::COLORS)], 
            self::MIN_MAX_VOLUME[array_rand(self::MIN_MAX_VOLUME)]
        );
    }

    /**
     * Generate an apple with random properties
     * 
     * @return Apple A new apple instance with random color, volume, and rotten state
     */
    private function generateApple(): Apple
    {
        return new Apple(
            self::COLORS[array_rand(self::COLORS)],
            rand(self::APPLE_MIN_MAX_VOLUME[0] * 10, self::APPLE_MIN_MAX_VOLUME[1] * 10) / 10,
            $this->isAppleRotten()
        );
    }

    /**
     * Determine if a generated apple should be rotten
     * 
     * Uses ROTTEN_PROBABILITY to randomly determine rotten state
     * 
     * @return bool True if apple should be rotten, false otherwise
     */
    private function isAppleRotten(): bool
    {
        return random_int(1, 100) <= (self::ROTTEN_PROBABILITY * 100);
    }
}