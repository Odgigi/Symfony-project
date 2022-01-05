<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{
    #[Route('/', name: 'annonce_index', methods: ['GET'])] // Cf. Template "Toutes les annonces" Attention bien rentrer '/' et non '/index' dans le navigateur qui renvoie vers une (fausse) erreur "Param Converter"
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'annonce_new', methods: ['GET', 'POST'])] // Cf. Template "Déposer une annonce" > annonce/_form
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        $annonce->setAnnonceUser($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'annonce_show', methods: ['GET'])] // Cf. Template "Annonce"
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    // #[Route('/{id}/edit', name: 'annonce_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Annonce $annonce, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(AnnonceType::class, $annonce);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('annonce/edit.html.twig', [
    //         'annonce' => $annonce,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'annonce_delete', methods: ['POST'])]
    // public function delete(Request $request, Annonce $annonce, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($annonce);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
    // }
}
