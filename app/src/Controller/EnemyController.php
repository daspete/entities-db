<?php

namespace App\Controller;

use App\Entity\Enemy;
use App\Form\EnemyFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EnemyController extends AbstractController
{
    #[Route('/enemy', name: 'app_enemy')]
    public function index(): Response
    {
        return $this->render('enemy/index.html.twig', [
            'controller_name' => 'EnemyController',
        ]);
    }

    #[Route('/enemy/create', name: 'app_enemy_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enemy = new Enemy();

        $form = $this->createForm(EnemyFormType::class, $enemy, [
            'action' => $this->generateUrl('app_enemy_create'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $enemy = $form->getData();
            $entityManager->persist($enemy);
            $entityManager->flush();

            return $this->redirectToRoute('app_enemy');
        }

        return $this->render('enemy/create.html.twig', [
            'enemyForm' => $form
        ]);
    }
}
