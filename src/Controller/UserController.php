<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Annonce;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    
    #[Route('/fetiches', name: 'user_fetiches', methods: ['GET'])] // Liste des fétiches d'un user
    public function userFeticheIndex(): Response
    {
        $user = $this->getUser();
        return $this->render('user/fetiches.html.twig', [
            'annonces' => $user->getFetiche(),
        ]);
    }

    #[Route('/fetiche/{id}', name: 'user_fetiche', methods: ['GET'])] // Détail d'un fétiche user
    public function userFeticheDetail(Annonce $annonce): Response
    {
        return $this->render('user/fetiche.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/annonces', name: 'user_annonces', methods: ['GET'])] // Liste des annonces d'un user
    public function userAnnonceIndex(): Response
    {
        $user = $this->getUser();
        return $this->render('user/annonces.html.twig', [
            'annonces' => $user->getAnnonces(),
        ]);
    }

    #[Route('/annonce/{id}', name: 'user_annonce', methods: ['GET'])] // Détail d'une annonce user
    public function userAnnonceDetail(Annonce $annonce): Response
    {
        return $this->render('user/annonce.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
