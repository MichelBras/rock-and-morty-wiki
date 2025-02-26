<?php

namespace App\Service;

readonly class CharacterService
{
    public function __construct(
        private RickAndMortyApiClient $apiClient
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

        $characters = $this->apiClient->getCharacters($characterIds);

        return [
            'id' => $dimension,
            'name' => $locationData['name'],
            'type' => $locationData['type'],
            'dimension' => $locationData['dimension'],
            'totalResidents' => count($characterIds),
            'residents' => $characters,
        ];
    }

    private function extractIdFromUrl(string $url): string
    {
        $parts = explode('/', rtrim($url, '/'));
        return end($parts);
    }
}
