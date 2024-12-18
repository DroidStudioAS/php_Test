<?php

namespace App\Factories;

use App\Models\Fruit;
use App\Models\Apple;

class FruitFactory{

    private const COLORS = ["red", "green", "yellow", "blue", "purple", "orange", "pink", "brown", "gray", "black", "white"];
    private const MIN_MAX_VOLUME = [1.0, 3.0];
    private const APPLE_MIN_MAX_VOLUME = [1.0, 5.0];
    private const ROTTEN_PROBABILITY = 0.2;

    public function generateFruit(string $type = null): Fruit
    {
        if ($type === null){
            return $this->generateRandomFruit();
        }
        return $this->generateApple();
    }

    private function generateRandomFruit(): Fruit
    {
        return new Fruit(
            self::COLORS[array_rand(self::COLORS)], 
            self::MIN_MAX_VOLUME[array_rand(self::MIN_MAX_VOLUME)]
        );
    }

    private function generateApple(): Apple
    {
        return new Apple(
            self::COLORS[array_rand(self::COLORS)],
            rand(self::APPLE_MIN_MAX_VOLUME[0] * 10, self::APPLE_MIN_MAX_VOLUME[1] * 10) / 10,
            $this->isAppleRotten()
        );
    }

    private function isAppleRotten(): bool
    {
        return mt_rand(1, 100) <= (self::ROTTEN_PROBABILITY * 100);
    }
}