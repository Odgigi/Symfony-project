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
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('fetiches/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'fetiches_show', methods: ['GET'])]
    public function show(Annonce $annonce): Response
    {
        return $this->render('fetiches/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }
}
