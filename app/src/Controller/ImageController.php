<?php

namespace App\Controller;

use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;

final class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function index(ImageManager $imageManager): Response
    {
        $image = $imageManager->create(200, 200);
        $image->fill('#f00');
        $convertedImage = $image->toWebp();

        $response = new Response($convertedImage);
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, 'test.webp');

        $response->headers->set('Content-Type', 'image/webp');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
