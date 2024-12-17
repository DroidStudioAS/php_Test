<?php

namespace App\Models;

use App\Exceptions\JuicerException;
use App\Validators\JuicerValidator;

class Strainer
{
    private float $capacity;
    private float $totalJuice = 0;

    public function __construct(float $capacity)
    {
        JuicerValidator::validateCapacity($capacity);
        $this->capacity = $capacity;
    }

    public function strainFruit(Fruit $fruit): float
    {
        JuicerValidator::validateForJuicing($fruit);

        $juiceAmount = $fruit->getJuiceAmount();
        $this->totalJuice += $juiceAmount;
        
        return $juiceAmount;
    }

    public function getTotalJuice(): float
    {
        return $this->totalJuice;
    }

    public function getCapacity(): float
    {
        return $this->capacity;
    }

    public function clear(): void
    {
        $this->totalJuice = 0;
    }

    public function toString(): string
    {
        return "Strainer has {$this->totalJuice}l of juice";
    }
}