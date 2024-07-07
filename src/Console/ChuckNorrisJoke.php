<?php

namespace Codingwithrk\ChuckNorrisJokes\Console;

use Codingwithrk\ChuckNorrisJokes\Facades\ChuckNorris;
use Illuminate\Console\Command;

class ChuckNorrisJoke extends Command
{
    protected $signature = 'chuck-norris';

    protected $description = 'Output a funny chuck norris jokes';

    public function handle()
    {
        $this->info(ChuckNorris::getRandomJoke());
    }
}