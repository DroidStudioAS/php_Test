<?php

namespace App\Interfaces;

use App\Models\Fruit;

interface StrainerInterface extends JuicerComponentInterface
{
    public function strainFruit(Fruit $fruit): float;
    public function getTotalJuice(): float;
} 