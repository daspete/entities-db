<?php

namespace App\Controller;

use App\Entity\Medium;
use App\Form\MediumFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class MediumController extends AbstractController
{
    #[Route('/medium', name: 'app_medium')]
    public function index(): Response
    {
        return $this->render('medium/index.html.twig', [
            'controller_name' => 'MediumController',
        ]);
    }

    #[Route('/medium/create', name: 'app_medium_create', priority: 1)]
    public function create(
        Request $request,
        SluggerInterface $slugger,
        EntityManagerInterface $entityManager,
    ): Response {
        $medium = new Medium();
        $payload = $request->getPayload();

        $form = $this->createForm(MediumFormType::class, $medium, [
            'action' => $this->generateUrl('app_medium_create'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('create_medium', $payload->getString('_token'))) {
            $file = $form->get('file')->getData();

            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move($this->getParameter('app.upload_dir'), $newFilename);
                    $medium->setFilename($newFilename);
                } catch (FileException $e) {
                    throw $e;
                }
            }

            $entityManager->persist($medium);
            $entityManager->flush();

            return $this->redirectToRoute('app_medium', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('medium/create.html.twig', [
            'mediumForm' => $form
        ]);
    }
}
