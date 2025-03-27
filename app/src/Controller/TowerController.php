<?php

namespace App\Controller;

use App\Entity\Tower;
use App\Form\TowerFormType;
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

    #[Route('/tower/{id}/delete', name: 'app_tower_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {
        $towerId = $request->get('id');
        $payload = $request->getPayload();

        $csrfToken = $payload->getString('_token');
        $csrfIsValid = $this->isCsrfTokenValid('delete_tower_' . $towerId, $csrfToken);

        if ($csrfIsValid) {
            $towerRepository = $entityManager->getRepository(Tower::class);
            $tower = $towerRepository->find($request->get('id'));

            $entityManager->remove($tower);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tower', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/tower/{id}', name: 'app_tower_edit')]
    public function update(Request $request, EntityManagerInterface $entityManager): Response
    {
        $towerRepository = $entityManager->getRepository(Tower::class);
        $tower = $towerRepository->find($request->get('id'));
        $payload = $request->getPayload();

        $form = $this->createForm(TowerFormType::class, $tower, [
            'action' => $this->generateUrl('app_tower_edit', ["id" => $tower->getId()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('update_tower_' . $request->get('id'), $payload->getString('_token'))) {
            $tower = $form->getData();
            $entityManager->persist($tower);
            $entityManager->flush();

            return $this->redirectToRoute('app_tower');
        }

        return $this->render('tower/update.html.twig', [
            'towerId' => $request->get('id'),
            'towerForm' => $form
        ]);
    }

    #[Route('/tower/create', name: 'app_tower_create', priority: 1)]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tower = new Tower();
        $payload = $request->getPayload();

        $form = $this->createForm(TowerFormType::class, $tower, [
            'action' => $this->generateUrl('app_tower_create'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('create_tower', $payload->getString('_token'))) {
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
