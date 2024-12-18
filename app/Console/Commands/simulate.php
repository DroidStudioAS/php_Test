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
        $i = 0;
        while ($i < self::TOTAL_ACTIONS){
        $this->info("Starting juicer simulation...\n");
        $type = $i % 9 == 0 && $i !== 0 ? "apple" : null;
        $this->info($type);

        $fruit = $fruitFactory->generateFruit($type);

        if ($fruit instanceof Apple && $fruit->isRotten()) {
            $this->info("found rotten apple, throwing it away");
            continue;
        }

        //add and strain fruit
        if ($this->juicer->getFruitContainer()->isFull($fruit->getVolume())) {
            $this->info("Fruit container is full, must clear the juicer before adding more fruit");
            $juiceContainer = new JuiceContainer($this->juicer->getTotalJuice());
            $this->juicerContainers[] = $juiceContainer;
            $this->juicer->clearJuicer();
        }
        $this->juicer->addFruit($fruit);
        

        $this->info("Total juice in strainer: " . $this->juicer->getStrainer()->getTotalJuice());
        $this->info("Capacity of fruit container: " . $this->juicer->getFruitContainer()->getCurrentVolume());
        $this->info("Total fruit in fruit container: " . $this->juicer->getFruitContainer()->getFruitCount());
        
        $i++;
    }
    $this->info("Number of juice containers: " . count($this->juicerContainers));
    foreach ($this->juicerContainers as $container) {
        $this->info($container->toString());
        }
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