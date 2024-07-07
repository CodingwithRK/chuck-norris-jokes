<?php

namespace Codingwithrk\ChuckNorrisJokes;

use Codingwithrk\ChuckNorrisJokes\Console\ChuckNorrisJoke;
use Codingwithrk\ChuckNorrisJokes\Http\Controllers\ChuckNorrisJokesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ChuckNorrisJokesServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ChuckNorrisJoke::class
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'chuck-norris');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/chuck-norris'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../config/chuck-norris.php' => base_path('config/chuck-norris.php'),
        ], 'config');

        if (!class_exists('CreateJokesTable')) {
            $this->publishes([
                __DIR__ . '/../Database/migrations/create_jokes_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_jokes_table.php'),
            ], 'migrations');
        }

        Route::get(config('chuck-norris.route'), ChuckNorrisJokesController::class);
    }

    public function register()
    {
        $this->app->bind('chuck-norris', function () {
            return new JokeFactory();
        });

        $this->loadMigrationsFrom(__DIR__ . '/../config/chuck-norris.php', 'chuck-norris');
    }

}