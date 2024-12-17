<?php

namespace App\Models;

use App\Models\Abstract\AbstractJuicerComponent;
use App\Interfaces\ContainerInterface;
use App\Exceptions\JuicerException;
use App\Validators\JuicerValidator;

class FruitContainer extends AbstractJuicerComponent implements ContainerInterface
{
    private float $currentVolume = 0;
    private int $fruitCount = 0;

    public function addFruit(Fruit $fruit): void
    {
        $newVolume = $this->currentVolume + $fruit->getVolume() / 2;
        JuicerValidator::validateContainerSpace($newVolume, $this->capacity);

        $this->currentVolume = $newVolume;
        $this->fruitCount++;
    }

    public function getFruitCount(): int
    {
        return $this->fruitCount;
    }

    public function getRemainingCapacity(): float
    {
        return $this->capacity - $this->currentVolume;
    }

    public function clear(): void
    {
        $this->currentVolume = 0;
        $this->fruitCount = 0;
    }

    public function toString(): string
    {
        return "Container capacity: {$this->capacity}L, fruits: {$this->fruitCount}, remaining capacity: {$this->getRemainingCapacity()}L";
    }
}
