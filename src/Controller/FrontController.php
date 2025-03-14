<?php

namespace App\Controller;

use App\Repository\ThreadRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FrontController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(ThreadRepository $threadRepo): Response
    {       
        $threads = $threadRepo->findAll();

        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            'threads' => $threads,
        ]);
    }

    #[Route('/thread/{id}', name: 'thread_show')]
    public function thread(ThreadRepository $threadRepo, int $id): Response
    {
        $thread = $threadRepo->find($id);

        return $this->render('front/thread.html.twig', [
            'controller_name' => 'FrontController',
            'thread' => $thread,
        ]);
    }
}
