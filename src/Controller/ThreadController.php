<?php

namespace App\Controller;

use App\Entity\Thread;
use App\Form\ThreadFormeType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig\EntityListeners\EntityConfig;

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

    #[Route('/thread', name: 'app_thread')]
    public function allthread(EntityManagerInterface $entitymanager): Response
    {
        $threadRepository = $entitymanager->getRepository(thread::class);

        $threads = $threadRepository->findAll();

        $thread = new Thread;
        $thread = $this->createForm(ThreadFormeType::class, $thread);

        return $this->render('thread/index.html.twig', [
            'controller_name' => 'ThreadController',
            'threads' => $threads
        ]);  
    }

    #[Route('/thread/{id}', name: 'app_thread_detail')]
    public function detailthread($id, EntityManagerInterface $entitymanager): Response
    {
        $threadRepository = $entitymanager->getRepository(thread::class);

        $thread = $threadRepository->find($id);

        return $this->render('thread/detail.html.twig', [
            'controller_name' => 'ThreadController',
            'thread' => $thread
        ]);  
    }
    
}
