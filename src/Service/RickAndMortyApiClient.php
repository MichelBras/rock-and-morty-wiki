<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RickAndMortyApiClient
{
    private const BASE_URL = 'https://rickandmortyapi.com/api';

    public function __construct(
        private readonly HttpClientInterface $client
    ) {}

    public function getAllDimensions(): array
    {
        $dimensions = [];
        $url = self::BASE_URL . '/location';

        do {
            $response = $this->client->request('GET', $url);
            $data = $response->toArray();

            $dimensions = [...$dimensions, ...$data['results']];
            $url = $data['info']['next'] ?? null;
        } while ($url);

        return $dimensions;
    }

    public function getLocation(string $dimension): array
    {
        $response = $this->client->request('GET', self::BASE_URL . '/location/' . $dimension);
        return $response->toArray();
    }

    public function getCharacters(array $characterIds): array
    {
        $idList = implode(',', $characterIds);
        $response = $this->client->request('GET', self::BASE_URL . '/character/' . $idList);
        $data = $response->toArray();

        return isset($data[0]) ? $data : [$data];
    }
}
