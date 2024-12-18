<?php

namespace App\Services;

use App\Models\Juicer;
use App\Models\JuiceContainer;
use App\Factories\FruitFactory;
use App\Exceptions\JuicerException;
use Illuminate\Console\Command;

class JuicerSimulation
{
    private const SQUEEZE_INTERVAL = 9;
    
    private array $juiceContainers = [];
    private Juicer $juicer;
    private FruitFactory $fruitFactory;
    private Command $output;
    private int $totalFruits = 0;
    private int $appleCount = 0;
    private int $rottenAppleCount = 0;

    public function __construct(Juicer $juicer, FruitFactory $fruitFactory, Command $output)
    {
        $this->juicer = $juicer;
        $this->fruitFactory = $fruitFactory;
        $this->output = $output;
    }

    public function processCycle(int $cycleNumber): void
    {
        $type = ($cycleNumber % self::SQUEEZE_INTERVAL === 0) ? "apple" : null;
        $fruit = $this->fruitFactory->generateFruit($type);

        if ($type === 'apple') {
            $this->handleApple($fruit);
            if ($fruit->isRotten()) {
                return;
            }
        }

        $this->processJuicing($fruit);
        $this->displayCycleInfo($cycleNumber);
    }

    private function handleApple($fruit): void
    {
        $this->appleCount++;
        $this->output->info("Generated apple with properties:");
        $this->output->info("Color: " . $fruit->getColor());
        $this->output->info("Volume: " . $fruit->getVolume());
        $this->output->info("Is Rotten: " . ($fruit->isRotten() ? 'true' : 'false'));
        
        if ($fruit->isRotten()) {
            $this->output->info("found rotten apple, throwing it away");
            $this->rottenAppleCount++;
        }
    }

    private function processJuicing($fruit): void
    {
        if ($this->juicer->getFruitContainer()->isFull($fruit->getVolume())) {
            
            $this->output->info("Fruit container is full, must clear the juicer before adding more fruit");
            $this->storeAndClearJuicer();
        }

        try {
            $this->juicer->addFruit($fruit);
            $this->totalFruits++;
        } catch (JuicerException $e) {
            if ($e->getMessage() === "Cannot juice rotten fruit.") {
                $this->output->info("found rotten apple, throwing it away");
                return;
            }
            throw $e;
        }
    }

    private function storeAndClearJuicer(): void
    {
        $juiceContainer = new JuiceContainer(
            $this->juicer->getTotalJuice(),
            $this->juicer->getFruitContainer()->getFruitCount()
        );
        $this->juiceContainers[] = $juiceContainer;
        $this->juicer->clearJuicer();
    }

    private function displayCycleInfo(int $cycleNumber): void
    {
        $this->output->info("\nSqueeze cycle: {$cycleNumber}");
        $this->output->info("Total juice in strainer: " . $this->juicer->getStrainer()->getTotalJuice());
        $this->output->info("Capacity of fruit container: " . $this->juicer->getFruitContainer()->getCurrentVolume());
        $this->output->info("Total fruit in fruit container: " . $this->juicer->getFruitContainer()->getFruitCount() . "\n");
    
    }

    public function displayFinalResults(): void
    {
        $this->output->info("Number of juice containers: " . count($this->juiceContainers));
        foreach ($this->juiceContainers as $container) {
            $this->output->info($container->toString());
        }
        $this->output->info("Total fruits squeezed: " . $this->totalFruits);
        $this->output->info("Attempted to use {$this->appleCount} apples, {$this->rottenAppleCount} were rotten");
    }

    public function calculateTotalJuice(): float
    {
        $totalJuice = array_reduce($this->juiceContainers, function($carry, $container) {
            return $carry + $container->getVolume();
        }, 0.0);
        
        return $totalJuice + $this->juicer->getStrainer()->getTotalJuice();
    }
} 