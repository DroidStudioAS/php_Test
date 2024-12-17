<?php

namespace App\Interfaces;

interface JuicerComponentInterface
{
    public function getCapacity(): float;
    public function clear(): void;
    public function toString(): string;
} 