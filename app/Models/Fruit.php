<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\FruitInterface;
class Fruit extends Model
{

    private string $color;
    private float $volumne; 

    public function __construct(string $color, string $volumne)
    {
        $this->color = $color;
        $this->volumne = $volumne;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getVolumne(): float
    {
        return $this->volumne;
    }

    public function to_string(): string
    {
        return "Fruit is {$this->color} and of {$this->volumne}l volume";
    }
}
