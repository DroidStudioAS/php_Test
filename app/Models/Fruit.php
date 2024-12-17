<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\FruitInterface;
use App\Exceptions\FruitException;
use App\Validators\FruitValidator;

class Fruit implements FruitInterface
{
    private string $color;
    private float $volume;

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

    public function getColor(): string
    {
        return $this->color;
    }

    public function getVolume(): float
    {
        return $this->volume;
    }

    public function toString(): string
    {
        return "Fruit is {$this->color} and of {$this->volume}l volume";
    }

    public function getJuiceAmount(): float
    {
        return $this->volume * 0.5; // 50% of fruit volume
    }
}
