<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\FruitInterface;

class Apple extends Fruit implements FruitInterface
{
    private bool $isRotten;

    public function __construct(string $color, float $volumne, bool $isRotten)
    {
        parent::__construct($color, $volumne);
        $this->isRotten = $isRotten;
    }

    public function isRotten(): bool
    {
        return $this->isRotten;
    }

    public function toString(): string
    {
        return "Apple is {$this->color} and of {$this->volumne}l volume. It is rotten: " . ($this->isRotten ? 'true' : 'false');
    }

}


