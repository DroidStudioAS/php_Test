<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\FruitFactory;
use App\Models\Juicer;
use App\Services\JuicerSimulation;

class simulate extends Command
{
    private const TOTAL_ACTIONS = 100;
    private const JUICER_CAPACITY = 20;

    protected $signature = 'juicer:simulate';
    protected $description = 'Simulates juicer operations';

    public function handle()
    {
        $juicer = new Juicer(
            new \App\Models\FruitContainer(self::JUICER_CAPACITY),
            new \App\Models\Strainer(self::JUICER_CAPACITY)
        );

        $simulation = new JuicerSimulation(
            $juicer,
            new FruitFactory(),
            $this
        );

        for ($i = 1; $i <= self::TOTAL_ACTIONS; $i++) {
            $simulation->processCycle($i);
        }

        $simulation->displayFinalResults();
    }
}