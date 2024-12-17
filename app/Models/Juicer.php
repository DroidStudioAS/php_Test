<?php

namespace App\Models;

class Juicer
{
    private FruitContainer $fruitContainer;
    private Strainer $strainer;

    public function __construct(FruitContainer $fruitContainer, Strainer $strainer){
        $this->fruitContainer = $fruitContainer;
        $this->strainer = $strainer;
    }

    public function addFruit(Fruit $fruit): void
    {
        $this->fruitContainer->addFruit($fruit);
    }

    public function getFruitContainer(): FruitContainer
    {
        return $this->fruitContainer;
    }

    public function getStrainer(): Strainer
    {
        return $this->strainer;
    }

    public function toString(): string
    {
        return "Juicer has {$this->fruitContainer->toString()} and {$this->strainer->toString()}";
    }
}
