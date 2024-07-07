<?php

namespace Codingwithrk\ChuckNorrisJokes\Tests;

use Codingwithrk\ChuckNorrisJokes\JokeFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class JokeFactoryTest extends TestCase
{
    #[Test]
    public function it_returns_a_random_joke()
    {

        $mock = new MockHandler([
            new Response(200, [], '{"categories":[],"created_at":"2020-01-05 13:42:27.496799","icon_url":"https://api.chucknorris.io/img/avatar/chuck-norris.png","id":"FVhfOt4XQ4i7LIwTHVi5_Q","updated_at":"2020-01-05 13:42:27.496799","url":"https://api.chucknorris.io/jokes/FVhfOt4XQ4i7LIwTHVi5_Q","value":"Chuck Norris has a picture of himself standing in the Grand Canyon, shirtless, oiled up and holding two sub-machineguns, and surrounded by naked ladies on his passport photo."}'
            ),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $jokes = new JokeFactory($client);


        $joke = $jokes->getRandomJoke();

        $this->assertSame('Chuck Norris has a picture of himself standing in the Grand Canyon, shirtless, oiled up and holding two sub-machineguns, and surrounded by naked ladies on his passport photo.', $joke);
    }
}