<?php

namespace App\Interfaces;

use App\Models\Fruit;

interface FruitFactoryInterface
{
    public function generateFruit(string $type = null): Fruit;
} 