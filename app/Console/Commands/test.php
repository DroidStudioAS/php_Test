<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fruit;
use App\Models\Apple;
use App\Exceptions\FruitException;
use App\Models\FruitContainer;
use App\Models\Strainer;
use App\Models\Juicer;
use App\Exceptions\JuicerException;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->testBadApple();
        $this->testValidFruits();
        $this->testGoodJuicer();
        $this->testBadJuicer();
        $this->testRottenApples();
    }

    /**
     * Test creating an invalid apple
     */
    private function testBadApple(): void
    {
        try {
            $badApple = new Apple("", "-0.2", "red");
            $this->info($badApple->toString());
        } catch (FruitException $e) {
            $this->error('Failed to create apple: ' . $e->getMessage());
            // Log the error if needed
            // \Log::error('Failed to create apple: ' . $e->getMessage());
        }
    }

    /**
     * Test creating valid fruits
     */
    private function testValidFruits(): void
    {
        try {
            $testFruit = new Fruit('red', 0.2);
            $testApple = new Apple("green", 0.1, false);

            $this->info('Valid fruit created: ' . $testFruit->toString());
            $this->info('Valid apple created: ' . $testApple->toString());
        } catch (FruitException $e) {
            $this->error('Failed to create valid fruits: ' . $e->getMessage());
            // Log the error if needed
            // \Log::error('Failed to create valid fruits: ' . $e->getMessage());
        }
    }
    private function testGoodJuicer(): void
    {
        try {
            $fruitContainer = new FruitContainer(10);
            $strainer = new Strainer(10);
            $juicer = new Juicer($fruitContainer, $strainer);
            $this->info($juicer->toString());
        } catch (JuicerException $e) {
            $this->error('Failed to create good juicer: ' . $e->getMessage());
        }
    }
    private function testBadJuicer(): void
    {
        try {
            $fruitContainer = new FruitContainer(-10);
            $strainer = new Strainer(-10);
            $juicer = new Juicer($fruitContainer, $strainer);
            $this->info($juicer->toString());
        } catch (JuicerException $e) {
            $this->error('Failed to create good juicer: ' . $e->getMessage());
        }
    }
    private function testRottenApples(): void
    {
        $factory = new FruitFactory();
        $rottenCount = 0;
        $totalApples = 100;

        for ($i = 0; $i < $totalApples; $i++) {
            $apple = $factory->generateFruit('apple');
            if ($apple instanceof Apple && $apple->isRotten()) {
                $rottenCount++;
            }
        }

        $this->info("Generated {$totalApples} apples");
        $this->info("Rotten apples: {$rottenCount}");
        $this->info("Rotten percentage: " . ($rottenCount/$totalApples * 100) . "%");
    }
}
