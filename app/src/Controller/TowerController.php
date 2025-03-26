<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TowerController extends AbstractController
{
    #[Route('/tower', name: 'app_tower')]
    public function index(): Response
    {
        return $this->render('tower/index.html.twig', [
            'controller_name' => 'TowerController',
        ]);
    }
}
