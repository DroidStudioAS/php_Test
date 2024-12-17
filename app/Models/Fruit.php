<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\FruitInterface;
class Fruit extends Model
{

    private string $color;
    private string $volumne; 

    public function __construct(string $color, string $volumne)
    {
        $this->color = $color;
        $this->volumne = $volumne;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getVolumne(): string
    {
        return $this->volumne;
    }
}
