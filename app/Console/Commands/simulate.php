<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\FruitFactory;
use App\Models\Juicer;
use App\Exceptions\JuicerException;
use App\Exceptions\FruitException;

class simulate extends Command
{
    private const TOTAL_ACTIONS = 100;
    private const JUICER_CAPACITY = 20;
    private const SQUEEZE_INTERVAL = 9;

    protected $signature = 'juicer:simulate';
    protected $description = 'Simulates juicer operations';

    public function handle()
    {
        $fruitFactory = new FruitFactory();
        $juicer = new Juicer(
            new \App\Models\FruitContainer(self::JUICER_CAPACITY),
            new \App\Models\Strainer(self::JUICER_CAPACITY)
        );

        $this->info("Starting juicer simulation...");

        for ($i = 0; $i < self::TOTAL_ACTIONS; $i++) {
            try {
                $fruit = $fruitFactory->generateFruit();
                $juicer->addFruit($fruit);
                
                $this->info("Added {$fruit->getColor()} fruit");

                if ($i > 0 && $i % self::SQUEEZE_INTERVAL === 0) {
                    $this->info("Squeezing fruits...");
                    $this->info($juicer->toString());
                }
            } catch (JuicerException | FruitException $e) {
                $this->info("Skipping fruit, capacity is full");
            }
        }

        $this->info("Simulation complete!");
    }
}