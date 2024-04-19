<?php

namespace App\Controller;

use App\Entity\Thread;
use Doctrine\ORM\Cache\EntityCacheEntry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{


    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $threadRepository = $entityManager->getRepository(Thread::class);

        $threads = $threadRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'threads' => $threads
        ]);
    }
}
