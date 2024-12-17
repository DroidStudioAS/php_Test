<?php

namespace App\Models\Abstract;

use App\Interfaces\JuicerComponentInterface;
use App\Validators\JuicerValidator;

abstract class AbstractJuicerComponent implements JuicerComponentInterface
{
    protected float $capacity;

    public function __construct(float $capacity)
    {
        JuicerValidator::validateCapacity($capacity);
        $this->capacity = $capacity;
    }

    public function getCapacity(): float
    {
        return $this->capacity;
    }

    abstract public function clear(): void;
    abstract public function toString(): string;
} 