<?php

namespace App\Services;

use App\Models\Juicer;
use App\Models\JuiceContainer;
use App\Factories\FruitFactory;
use App\Exceptions\JuicerException;
use Illuminate\Console\Command;

/**
 * Class JuicerSimulation
 * 
 * Service class that simulates the operation of a juicer.
 * Handles the simulation of 100 consecutive actions with specific rules for apple generation.
 * 
 * @package App\Services
 */
class JuicerSimulation
{
    /** @var int Number of cycles between apple generations */
    private const SQUEEZE_INTERVAL = 9;
    
    /** @var array<JuiceContainer> Array of juice containers used in simulation */
    private array $juiceContainers = [];

    /** @var Juicer The juicer instance being simulated */
    private Juicer $juicer;

    /** @var FruitFactory Factory for generating fruits */
    private FruitFactory $fruitFactory;

    /** @var Command Console command instance for output */
    private Command $output;

    /** @var int Total number of fruits processed */
    private int $totalFruits = 0;

    /** @var int Total number of apples generated */
    private int $appleCount = 0;

    /** @var int Number of rotten apples encountered */
    private int $rottenAppleCount = 0;

    /**
     * Constructs a new JuicerSimulation instance
     * 
     * @param Juicer       $juicer       The juicer to simulate
     * @param FruitFactory $fruitFactory Factory for generating fruits
     * @param Command      $output       Console command for output
     */
    public function __construct(Juicer $juicer, FruitFactory $fruitFactory, Command $output)
    {
        $this->juicer = $juicer;
        $this->fruitFactory = $fruitFactory;
        $this->output = $output;
    }

    /**
     * Process a single simulation cycle
     * 
     * @param int $cycleNumber The current cycle number
     * @return void
     */
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

    /**
     * Handle apple-specific processing
     * 
     * @param Fruit $fruit The apple to process
     * @return void
     */
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

    /**
     * Process juicing of a fruit
     * 
     * @param Fruit $fruit The fruit to juice
     * @return void
     * @throws JuicerException When juicing fails
     */
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

    /**
     * Store current juice and clear the juicer
     * 
     * @return void
     */
    private function storeAndClearJuicer(): void
    {
        $juiceContainer = new JuiceContainer(
            $this->juicer->getTotalJuice(),
            $this->juicer->getFruitContainer()->getFruitCount()
        );
        $this->juiceContainers[] = $juiceContainer;
        $this->juicer->clearJuicer();
    }

    /**
     * Display information about the current cycle
     * 
     * @param int $cycleNumber The current cycle number
     * @return void
     */
    private function displayCycleInfo(int $cycleNumber): void
    {
        $this->output->info("\nSqueeze cycle: {$cycleNumber}");
        $this->output->info("Total juice in strainer: " . $this->juicer->getStrainer()->getTotalJuice());
        $this->output->info("Capacity of fruit container: " . $this->juicer->getFruitContainer()->getCurrentVolume());
        $this->output->info("Total fruit in fruit container: " . $this->juicer->getFruitContainer()->getFruitCount() . "\n");
    }

    /**
     * Display final simulation results
     * 
     * @return void
     */
    public function displayFinalResults(): void
    {
        $this->output->info("Number of juice containers: " . count($this->juiceContainers));
        foreach ($this->juiceContainers as $container) {
            $this->output->info($container->toString());
        }
        $this->output->info("Total fruits squeezed: " . $this->totalFruits);
        $this->output->info("Attempted to use {$this->appleCount} apples, {$this->rottenAppleCount} were rotten");
    }

    /**
     * Calculate total juice produced in simulation
     * 
     * @return float Total juice in liters
     */
    public function calculateTotalJuice(): float
    {
        $totalJuice = array_reduce($this->juiceContainers, function($carry, $container) {
            return $carry + $container->getVolume();
        }, 0.0);
        
        return $totalJuice + $this->juicer->getStrainer()->getTotalJuice();
    }
} 