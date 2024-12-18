<?php

namespace App\Models;

use App\Models\Abstract\AbstractJuicerComponent;
use App\Validators\JuicerValidator;
use App\Exceptions\JuicerException;

class JuiceContainer
{
    const CAPACITY = 20.0;
    private float $volume = 0;
    private int $numberOfFruits;

    public function __construct(float $amountInLiteres, int $numberOfFruits)
    {   
        if ($amountInLiteres > self::CAPACITY) {
            throw new JuicerException("Juice amount is too large");
        }
        $this->numberOfFruits = $numberOfFruits;
        $this->volume = $amountInLiteres;
    }

    public function getVolume(): float
    {
        return $this->volume;
    }

    public function toString(): string
    {
        return "Juice Container has {$this->volume}L of juice made of {$this->numberOfFruits} fruits";
    }
} 