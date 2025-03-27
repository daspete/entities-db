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
    public function index(EntityManagerInterface $entityManager): Response
    {
        $enemyRepository = $entityManager->getRepository(Enemy::class);

        $enemies = $enemyRepository->findAll();

        return $this->render('enemy/index.html.twig', [
            'enemies' => $enemies,
        ]);
    }

    #[Route('/enemy/{id}/delete', name: 'app_enemy_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enemyId = $request->get('id');
        $payload = $request->getPayload();

        $csrfToken = $payload->getString('_token');
        $csrfIsValid = $this->isCsrfTokenValid('delete_enemy_' . $enemyId, $csrfToken);

        if ($csrfIsValid) {
            $enemyRepository = $entityManager->getRepository(Enemy::class);
            $enemy = $enemyRepository->find($request->get('id'));

            $entityManager->remove($enemy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_enemy', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/enemy/{id}', name: 'app_enemy_edit')]
    public function update(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enemyRepository = $entityManager->getRepository(Enemy::class);
        $enemy = $enemyRepository->find($request->get('id'));
        $payload = $request->getPayload();

        $form = $this->createForm(EnemyFormType::class, $enemy, [
            'action' => $this->generateUrl('app_enemy_edit', ["id" => $enemy->getId()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('update_enemy_' . $request->get('id'), $payload->getString('_token'))) {
            $enemy = $form->getData();
            $entityManager->persist($enemy);
            $entityManager->flush();

            return $this->redirectToRoute('app_enemy');
        }

        return $this->render('enemy/update.html.twig', [
            'enemyId' => $request->get('id'),
            'enemyForm' => $form
        ]);
    }

    #[Route('/enemy/create', name: 'app_enemy_create', priority: 1)]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enemy = new Enemy();
        $payload = $request->getPayload();

        $form = $this->createForm(EnemyFormType::class, $enemy, [
            'action' => $this->generateUrl('app_enemy_create'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('create_enemy', $payload->getString('_token'))) {
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
