<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FruitContainer extends Model
{
    private float $volumne;
    private int $fruitsInContainer;

    public function __construct(float $volumne)
    {
        $this->volumne = $volumne;
        $this->fruitsInContainer = 0;
    }
    public function addFruitToContainer (): void
    {
        $this->fruitsInContainer++;
    }

    public function getFruitsInContainer(): int
    {
        return $this->fruitsInContainer;
    }

    public function getVolume(): float
    {
        return $this->volumne;
    }

}
