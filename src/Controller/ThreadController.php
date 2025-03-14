<?php
// filepath: src/Controller/ThreadController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UrlPreviewService;

class ThreadController extends AbstractController
{
    private $urlPreviewService;

    public function __construct(UrlPreviewService $urlPreviewService)
    {
        $this->urlPreviewService = $urlPreviewService;
    }

    #[Route("/submit-url", name: "submit_url", methods :"POST")]
    public function submitUrl(Request $request): Response
    {
        $url = $request->request->get('url');
        $metadata = $this->urlPreviewService->fetchMetadata($url);

        return $this->render('front/thread.html.twig', [
            'metadata' => $metadata,
        ]);
    }
}