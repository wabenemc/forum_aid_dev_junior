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
        // Instancier l'entité que l'on souhaite créer
        $thread = new Thread();

        // Créer le formulaire en s'appuyant sur la configuration de ce dernier
        $form = $this->createForm(ThreadFormeType::class, $thread);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Lorsque formulaire est soumis, vérifier s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            // Persister et enregister en base de données.
            $entityManager->persist($thread);
            $entityManager->flush();
        }

        return $this->render('thread/create.html.twig', [
            'controller_name' => 'ThreadController',
            'Form' => $form
        ]);
    }

    /**
     * Route pour le formulaire d'édition
     */
    #[Route('/thread/{id}/edit', name: 'app_thread_edit')]
    public function editThread(
        $id,
        EntityManagerInterface $entityManager,
        Request $request
    ) {
        // Même chose qu'avant : appel du répertoire + utilisation d'une méthode, ici "find".
        $characterRepository = $entityManager->getRepository(thread::class);
        $character = $characterRepository->find($id);

        // Créer le formulaire en s'appuyant sur la configuration de ce dernier
        $form = $this->createForm(ThreadFormeType::class, $character);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Lorsque formulaire est soumis, vérifier s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $character->setCreatedAt(new \DateTimeImmutable);

            // Persister et enregister en base de données.
            $entityManager->persist($character);
            $entityManager->flush();
        }

        return $this->render('thread/edit.html.twig', [
            'controller_name' => 'ThreadController',
            'editForm' => $form
        ]);
    }

}
    

