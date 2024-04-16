<?php

namespace App\Controller;

use App\Entity\Thread;
use App\Form\ThreadFormeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ThreadController extends AbstractController
{
    #[Route('/thread', name: 'app_thread')]
    public function index(): Response
    {
        $thread = new Thread;
        $form = $this->createForm(ThreadFormeType::class, $thread);

        return $this->render('thread/index.html.twig', [
            'controller_name' => 'ThreadController',
            'form' => $form

        ]);
    }
}
