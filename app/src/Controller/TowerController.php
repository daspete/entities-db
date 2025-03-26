<?php

namespace App\Controller;

use App\Entity\Tower;
use App\Form\TowerFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TowerController extends AbstractController
{
    #[Route('/tower', name: 'app_tower')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $towerRepository = $entityManager->getRepository(Tower::class);

        $towers = $towerRepository->findAll();

        return $this->render('tower/index.html.twig', [
            'towers' => $towers,
        ]);
    }

    #[Route('/tower/create', name: 'app_tower_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tower = new Tower();

        $form = $this->createForm(TowerFormType::class, $tower, [
            'action' => $this->generateUrl('app_tower_create'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $tower = $form->getData();
            $entityManager->persist($tower);
            $entityManager->flush();

            return $this->redirectToRoute('app_tower');
        }

        return $this->render('tower/create.html.twig', [
            'towerForm' => $form
        ]);
    }
}
