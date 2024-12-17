<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fruit;

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

       $this->info($testFruit->toString());
    }
}
