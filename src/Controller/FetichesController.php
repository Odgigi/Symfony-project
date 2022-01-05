<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\Annonce2Type;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fetiches')]
class FetichesController extends AbstractController
{
    #[Route('/', name: 'fetiches_index', methods: ['GET'])]
    public function index(AnnonceRepository $a): Response // affiche tous les fétiches des Users
    {
        dump($a->findFetichedAnnonce()); // affichage dev à supprimer
        $user = $this->getUser();
        return $this->render('fetiches/index.html.twig', [
            'annonces' => $user->getFetiche(),
        ]);
    }

    #[Route('/{id}', name: 'fetiches_show', methods: ['GET'])] // affiche le détail d'un fétiche
    public function show(Annonce $annonce): Response // se recoupe avec user_fetiche > gelée
    {
        return $this->render('fetiches/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/add/{id}", name="fetiches_add", methods={"GET"})
     */
    public function add(Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $user->addFetiche($annonce); // pour mettre une annonce en fétiche
        $entityManager->flush();

        return $this->redirectToRoute('annonce_show', [ // redirection sur la page courante : annonce
            'id' => $annonce->getId()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="fetiches_delete", methods={"GET"})
     */
    public function delete(Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $user->removeFetiche($annonce); // pour supprimer un fétiche
        $entityManager->flush();
        
        return $this->redirectToRoute('fetiches_index');
    }
}
