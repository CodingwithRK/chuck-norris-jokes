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
            new Response(200, [], '{
                  "status": "valid",
                  "message": "Fake users are getting successfully",
                  "total_count": 1,
                  "data": [
                    {
                      "name": "Dr. Kiley D\'Amore Jr."
                    }
                  ]
                }'
            ),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $jokes = new JokeFactory($client);


        $joke = $jokes->getRandomJoke();

        $this->assertSame('Fake users are getting successfully', $joke);
    }
}