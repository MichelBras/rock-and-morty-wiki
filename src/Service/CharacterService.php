<?php

namespace App\Service;

class CharacterService
{
    public function __construct(
        private readonly RickAndMortyApiClient $apiClient
    ) {}

    public function getDimensionCharacters(string $dimension): array
    {
        $locationData = $this->apiClient->getLocation($dimension);

        $characterIds = array_unique(
            array_map(
                fn(string $url) => $this->extractIdFromUrl($url),
                $locationData['residents']
            )
        );

        return [
            'id' => $dimension,
            'name' => $locationData['name'],
            'type' => $locationData['type'],
            'dimension' => $locationData['dimension'],
            'residents' => $this->apiClient->getCharacters($characterIds),
        ];
    }

    private function extractIdFromUrl(string $url): string
    {
        $parts = explode('/', rtrim($url, '/'));
        return end($parts);
    }
}
