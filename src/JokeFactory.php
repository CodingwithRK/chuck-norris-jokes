<?php

namespace Codingwithrk\ChuckNorrisJokes;

use GuzzleHttp\Client;

class JokeFactory
{
    const API_END = 'https://api.chucknorris.io/jokes/random';

    protected $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    public function getRandomJoke()
    {
        $response = $this->client->get(self::API_END);

        $joke =  json_decode($response->getBody()->getContents(), true);

        return $joke['value'];
    }

}
