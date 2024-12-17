<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class simulate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'juicer:simulate';

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
        $fruitFactory = new FruitFactory();
        
    }
}
