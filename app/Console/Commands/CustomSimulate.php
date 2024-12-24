<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\FruitFactory;
use App\Models\Juicer;
use App\Services\JuicerSimulation;
use App\Models\FruitContainer;
use App\Models\Strainer;

class CustomSimulate extends Command
{
    protected $signature = 'juicer:custom-simulate';
    protected $description = 'Simulates juicer operations with custom parameters';

    private const DEFAULT_JUICER_CAPACITY = 20;
    private const MIN_CYCLES = 1;
    private const MAX_CYCLES = 1000;
    private const MIN_APPLE_INTERVAL = 2;
    private const MAX_APPLE_INTERVAL = 100;
    private const MIN_FRUIT_VOLUME = 0.1;
    private const MAX_FRUIT_VOLUME = 10.0;

    public function handle()
    {
        $this->info("Welcome to Custom Juicer Simulation!");
        $this->info("Please provide the following parameters:\n");

        // Get user inputs with validation
        $totalCycles = $this->getTotalCycles();
        $appleInterval = $this->getAppleInterval();
        $minFruitVolume = $this->getMinFruitVolume();

        // Initialize simulation components
        $juicer = new Juicer(
            new FruitContainer(self::DEFAULT_JUICER_CAPACITY),
            new Strainer(self::DEFAULT_JUICER_CAPACITY)
        );

        // Create fruit factory with custom minimum volume
        $fruitFactory = new FruitFactory();
        $fruitFactory->setMinimumVolume($minFruitVolume);

        $simulation = new JuicerSimulation(
            $juicer,
            $fruitFactory,
            $this,
            $appleInterval // Pass custom apple interval
        );

        // Run simulation
        $this->info("\nStarting simulation with:");
        $this->info("- Total cycles: $totalCycles");
        $this->info("- Apple every: $appleInterval fruits");
        $this->info("- Minimum fruit volume: $minFruitVolume liters\n");

        for ($i = 1; $i <= $totalCycles; $i++) {
            $simulation->processCycle($i);
        }

        $simulation->displayFinalResults();
    }

    private function getTotalCycles(): int
    {
        while (true) {
            $cycles = $this->ask(
                "How many squeeze cycles would you like to run? (" . 
                self::MIN_CYCLES . "-" . self::MAX_CYCLES . ")"
            );

            if (!is_numeric($cycles)) {
                $this->error("Please enter a valid number.");
                continue;
            }

            $cycles = (int)$cycles;
            if ($cycles < self::MIN_CYCLES || $cycles > self::MAX_CYCLES) {
                $this->error("Please enter a number between " . self::MIN_CYCLES . 
                    " and " . self::MAX_CYCLES);
                continue;
            }

            return $cycles;
        }
    }

    private function getAppleInterval(): int
    {
        while (true) {
            $interval = $this->ask(
                "After how many fruits should an apple be generated? (" . 
                self::MIN_APPLE_INTERVAL . "-" . self::MAX_APPLE_INTERVAL . ")"
            );

            if (!is_numeric($interval)) {
                $this->error("Please enter a valid number.");
                continue;
            }

            $interval = (int)$interval;
            if ($interval < self::MIN_APPLE_INTERVAL || $interval > self::MAX_APPLE_INTERVAL) {
                $this->error("Please enter a number between " . self::MIN_APPLE_INTERVAL . 
                    " and " . self::MAX_APPLE_INTERVAL);
                continue;
            }

            return $interval;
        }
    }

    private function getMinFruitVolume(): float
    {
        while (true) {
            $volume = $this->ask(
                "What should be the minimum fruit volume in liters? (" . 
                self::MIN_FRUIT_VOLUME . "-" . self::MAX_FRUIT_VOLUME . ")"
            );

            if (!is_numeric($volume)) {
                $this->error("Please enter a valid number.");
                continue;
            }

            $volume = (float)$volume;
            if ($volume < self::MIN_FRUIT_VOLUME || $volume > self::MAX_FRUIT_VOLUME) {
                $this->error("Please enter a number between " . self::MIN_FRUIT_VOLUME . 
                    " and " . self::MAX_FRUIT_VOLUME);
                continue;
            }

            return $volume;
        }
    }
} 