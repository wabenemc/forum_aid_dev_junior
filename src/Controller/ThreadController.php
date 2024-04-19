<?php

namespace App\Controller;

use App\Entity\Thread;
use App\Form\ThreadFormeType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig\EntityListeners\EntityConfig;

class ThreadController extends AbstractController
{

    #[Route('/thread', name: 'app_thread')]
    public function allthread(EntityManagerInterface $entitymanager): Response
    {
        $threadRepository = $entitymanager->getRepository(Thread::class);

        $threads = $threadRepository->findAll();


        return $this->render('thread/index.html.twig', [
            'controller_name' => 'ThreadController',
            'threads' => $threads
        ]);
    }



    #[Route('/thread/{id}', name: 'app_thread_detail')]
    public function detailthread($id, EntityManagerInterface $entitymanager): Response
    {
        $threadRepository = $entitymanager->getRepository(Thread::class);

        $thread = $threadRepository->find($id);

        return $this->render('thread/detail.html.twig', [
            'controller_name' => 'ThreadController',
            'thread' => $thread
        ]);
    }



    #[Route('/thread/new', name: 'app_thread_new', priority: 10)]
    public function createTread(
        Request $request,
        EntityManagerInterface $entityManager
    ) {

        $thread = new Thread();

        $form = $this->createForm(ThreadFormeType::class, $thread);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($thread);
            $entityManager->flush();
            return $this->redirectToRoute('thread_show', ['id' => $thread->getId()]);
        }

        return $this->render('thread/create.html.twig', [
            'controller_name' => 'ThreadController',
            'Form' => $form

        ]);
    }


    #[Route('/thread/{id}/edit', name: 'app_thread_edit')]
    public function editThread(
        $id,
        EntityManagerInterface $entityManager,
        Request $request
    ) {
        $characterRepository = $entityManager->getRepository(thread::class);
        $character = $characterRepository->find($id);

        $form = $this->createForm(ThreadFormeType::class, $character);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $character->setCreatedAt(new \DateTimeImmutable);

            $entityManager->persist($character);
            $entityManager->flush();
        }

        return $this->render('thread/edit.html.twig', [
            'controller_name' => 'ThreadController',
            'editForm' => $form
        ]);
    }



    #[Route('/thread/show/{id}', name: 'app_thread_show')]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $threadRepository = $entityManager->getRepository(thread::class);
        $thread = $threadRepository->find($id);
        return $this->render('thread/show.html.twig', [
            'thread' => $thread,
        ]);
    }
}
