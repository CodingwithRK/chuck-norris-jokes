<?php

namespace Codingwithrk\ChuckNorrisJokes\Tests;

use Codingwithrk\ChuckNorrisJokes\ChuckNorrisJokesServiceProvider;
use Codingwithrk\ChuckNorrisJokes\Facades\ChuckNorris;
use Codingwithrk\ChuckNorrisJokes\Http\Models\Joke;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LaravelTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [
            ChuckNorrisJokesServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'ChuckNorris' => ChuckNorris::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        include_once __DIR__ . '/../database/migrations/create_jokes_table.php.stub';

        (new \CreateJokesTable)->up();
    }

    #[Test]
    public function the_console_command_returns_a_joke()
    {
        $this->withoutMockingConsoleOutput();

        ChuckNorris::shouldReceive('getRandomJoke')
            ->once()
            ->andReturn('some joke');

        $this->artisan('chuck-norris');

        $output = Artisan::output();

        $this->assertSame('some joke' . PHP_EOL, $output);
    }

    #[Test]
    public function the_route_can_be_accessed()
    {
        ChuckNorris::shouldReceive('getRandomJoke')
            ->once()
            ->andReturn('some joke');

        $this->get('/chuck-norris')
            ->assertViewIs('chuck-norris::jokes')
            ->assertViewHas('joke', 'some joke')
            ->assertStatus(200);
    }

    #[Test]
    public function it_can_access_the_database()
    {
        $joke = new Joke();
        $joke->joke = 'This is funny joke';
        $joke->save();

        $newJoke = Joke::find($joke->id);
        $this->assertSame($newJoke->joke, 'This is funny joke');
    }
}
