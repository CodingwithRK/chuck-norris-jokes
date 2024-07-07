<?php

namespace Codingwithrk\ChuckNorrisJokes\Http\Controllers;

use Codingwithrk\ChuckNorrisJokes\Facades\ChuckNorris;

class ChuckNorrisJokesController
{
    public function __invoke() {
        return view('chuck-norris::jokes', [
            'joke' => ChuckNorris::getRandomJoke()
        ]);
    }
}