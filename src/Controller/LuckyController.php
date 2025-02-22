<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LuckyController extends AbstractController
{
    #[Route('/lucky/number', name: 'lucky_number')]
    public function index(): Response
    {
        $number = random_int(0, 100);

        return $this->render('lucky/index.html.twig', [
            'number' => $number,
        ]);
    }
}
