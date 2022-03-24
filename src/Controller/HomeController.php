<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findBy([], ['id' => 'DESC'], 6);
        return $this->render('home/index.html.twig', [
            'annonces' => $annonces
        ]);
    }
}
