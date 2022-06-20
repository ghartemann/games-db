<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RAWGConnector
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getInfosGame(string $title): array|null
    {
        $response = $this->client->request(
            'GET',
            'https://api.rawg.io/api/games/' . $title . '?key=561f603be0f947e58b4a2c9c45e3cb57'
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode == 404) {
            return null;
        } else {
            $game = $response->toArray();
            return $game;
        }
    }
}
