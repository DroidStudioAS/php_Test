<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\FruitInterface;
use App\Exceptions\FruitException;
use App\Validators\FruitValidator;

class Apple extends Fruit implements FruitInterface
{
    private bool $isRotten;

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

    public function isRotten(): bool
    {
        return $this->isRotten;
    }

    public function toString(): string
    {
        return "Apple is {$this->getColor()} and of {$this->getVolume()}l volume. It is rotten: " . 
            ($this->isRotten ? 'true' : 'false');
    }
}


