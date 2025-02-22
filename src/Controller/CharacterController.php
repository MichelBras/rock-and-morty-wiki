<?php

namespace App\Controller;

use App\Service\CharacterService;
use App\Service\RickAndMortyApiClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CharacterController extends AbstractController
{
    public function __construct(
        private readonly RickAndMortyApiClient $apiClient,
        private readonly CharacterService $characterService
    ) {}

    #[Route('/characters', name: 'characters_page', methods: ['GET'])]
    public function charactersPage(): Response
    {
        return $this->render('characters/index.html.twig', [
            'dimensions' => $this->apiClient->getAllDimensions(),
        ]);
    }

    #[Route('/dimension/{dimension}/characters', name: 'characters_by_dimension', methods: ['GET'])]
    public function getCharactersByDimension(string $dimension): JsonResponse
    {
        return new JsonResponse(
            $this->characterService->getDimensionCharacters($dimension)
        );
    }
}
