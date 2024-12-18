<?php

namespace App\Models;

use App\Exceptions\JuicerException;
use App\Models\Apple;

/**
 * Class Juicer
 * 
 * Main class representing a juicer machine.
 * Combines a fruit container and strainer to process fruits into juice.
 * 
 * @package App\Models
 */
class Juicer
{
    /** @var FruitContainer Container component for storing fruits */
    private FruitContainer $fruitContainer;

    /** @var Strainer Strainer component for extracting juice */
    private Strainer $strainer;

    /**
     * Constructs a new Juicer instance
     * 
     * @param FruitContainer $fruitContainer Container for storing fruits
     * @param Strainer      $strainer       Strainer for extracting juice
     */
    public function __construct(FruitContainer $fruitContainer, Strainer $strainer){
        $this->fruitContainer = $fruitContainer;
        $this->strainer = $strainer;
    }

    /**
     * Add a fruit to the juicer for processing
     * 
     * @param Fruit $fruit The fruit to process
     * @throws JuicerException When fruit is rotten or container is full
     * @return void
     */
    public function addFruit(Fruit $fruit): void
    {    
        // Check for rotten apple first
        if ($fruit instanceof Apple && $fruit->isRotten()) {
            throw JuicerException::rottenFruit();
        }

        $this->fruitContainer->addFruit($fruit);
        $this->strainer->strainFruit($fruit);   
    }
    
    /**
     * Get the fruit container component
     * 
     * @return FruitContainer The juicer's fruit container
     */
    public function getFruitContainer(): FruitContainer
    {
        return $this->fruitContainer;
    }

    /**
     * Get the strainer component
     * 
     * @return Strainer The juicer's strainer
     */
    public function getStrainer(): Strainer
    {
        return $this->strainer;
    }

    /**
     * Get a string representation of the juicer state
     * 
     * @return string Description of juicer including container and strainer states
     */
    public function toString(): string
    {
        return "Juicer has {$this->fruitContainer->toString()} and {$this->strainer->toString()}";
    }

    /**
     * Squeeze fruits in the container to extract juice
     * 
     * @return float Amount of juice extracted in liters
     */
    public function squeeze(): float
    {
        $juiceAmount = 0;
        if ($this->fruitContainer->getFruitCount() > 0) {
            $this->fruitContainer->clear();
            $juiceAmount = $this->strainer->getTotalJuice();
        }
        return $juiceAmount;
    }

    /**
     * Clear both the fruit container and strainer
     * 
     * @return void
     */
    public function clearJuicer(): void
    {
        $this->fruitContainer->clear();
        $this->strainer->clear();
    }

    /**
     * Get the total amount of juice in the juicer
     * 
     * @return float Total amount of juice in liters
     */
    public function getTotalJuice(): float
    {
        return $this->strainer->getTotalJuice();
    }
}
