<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\FruitFactory;
use App\Models\Juicer;
use App\Exceptions\JuicerException;
use App\Exceptions\FruitException;
use App\Models\JuiceContainer;

class simulate extends Command
{
    private const TOTAL_ACTIONS = 100;
    private const JUICER_CAPACITY = 20;
    private const SQUEEZE_INTERVAL = 9;

    protected $signature = 'juicer:simulate';
    protected $description = 'Simulates juicer operations';

    private array $juicerContainers = [];
    private Juicer $juicer;

    public function __construct()
    {
        parent::__construct();
        $this->juicer = new Juicer(
            new \App\Models\FruitContainer(self::JUICER_CAPACITY),
            new \App\Models\Strainer(self::JUICER_CAPACITY)
        );
    }

    public function handle()
    {
        $fruitFactory = new FruitFactory();

        $this->info("Starting juicer simulation...\n");

        for ($i = 0; $i < self::TOTAL_ACTIONS; $i++) {
            $success = false;
            while (!$success) {
                try {
                    $type = $i % 9 == 0 && $i !== 0 ? "apple" : null;
                    $fruit = $fruitFactory->generateFruit($type);
                    $this->juicer->addFruit($fruit);
                    
                    $strainer = $this->juicer->getStrainer();
                    $container = $this->juicer->getFruitContainer();

                    $this->info(sprintf(
                        "Action %d: Added %s fruit (%.2fL)\n" .
                        "Container Status: %.2fL/%.2fL\n" .
                        "Total Juice Produced: %.1fL\n",
                        $i + 1,
                        $fruit->getColor(),
                        $fruit->getVolume(),
                        $container->getCurrentVolume(),
                        $container->getCapacity(),
                        $strainer->getCapacity(),
                        $strainer->getTotalJuice()
                    ));

                    if ($i > 0 && $i % self::SQUEEZE_INTERVAL === 0) {
                        $this->info("\n=== Squeezing fruits ===");
                        $this->info($this->juicer->toString() . "\n");
                    }

                    $success = true; // Mark the iteration as successful
                } catch (JuicerException | FruitException $e) {
                    $this->info("We need to empty the juicer, because it is full");
                    $this->info($strainer->getTotalJuice());
                    $juicerContainer = new JuiceContainer($strainer->getTotalJuice());
                    $this->juicerContainers[] = $juicerContainer;
                    $strainer->clear();
                    $this->juicer->getFruitContainer()->clear();
                    // Retry the iteration
                }
            }
        }

        $this->info("\n=== Simulation Complete ===");
        $this->info($this->juicer->toString());
        $this->info(sprintf(
            "Total Juice Containers Filled: %d\n" .
            "Total Juice Produced: %.1fL",
            count($this->juicerContainers),
            $this->calculateTotalJuice()
        ));
    }
    public function calculateTotalJuice():float{
        $totalJuice = 0;
        foreach ($this->juicerContainers as $container) {
            $totalJuice += $container->getVolume();
        }
        $totalJuice += $this->juicer->getStrainer()->getTotalJuice();
        return $totalJuice;
    }
}