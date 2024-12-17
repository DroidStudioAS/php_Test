<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fruit;
use App\Models\Apple;

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
       $testFruit = new Fruit('red', 0.2);
       $testApple = new Apple("green", 0.1, false);
       
       $this->info($testFruit->toString());
       $this->info($testApple->toString());
    }
}
