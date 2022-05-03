<?php

namespace App\Controller;

use App\Entity\Note;
use App\Classe\Search;
use App\Form\NoteType;
use App\Entity\Annonce;
use App\Form\SearchType;
use App\Form\AnnonceType;
use App\Repository\NoteRepository;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/', name: 'annonce_index', methods: ['GET'])] // Cf. Template "Toutes les annonces" Attention bien rentrer '/' dans le navigateur et non '/index' qui renvoie vers une (fausse) erreur "Param Converter"
    public function index(Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonces = $this->entityManager->getRepository(Annonce::class)->findWithSearch($search);
        } else {
            
            $annonces = $this->entityManager->getRepository(Annonce::class)->findAll();
        }
        
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'form' => $form->createView()
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

            $infoImg1 = $form['img1']->getData(); // récupère les informations de l'image 1
                $extensionImg1 = $infoImg1->guessExtension(); // récupère l'extension de fichier de l'image 1
                $nomImg1 = time() . '-1.' . $extensionImg1; // reconstitue un nom d'image unique pour l'image 1
                $infoImg1->move($this->getParameter('annonce_pictures_directory'), $nomImg1); // déplace l'image dans le dossier adéquat
                $annonce->setImg1($nomImg1);

            $infoImg2 = $form['img2']->getData();
                if ($infoImg2 !== null) {
                    $extensionImg2 = $infoImg2->guessExtension(); // récupère l'extension de fichier de l'image 2
                    $nomImg2 = time() . '-2.' . $extensionImg2;
                    $infoImg2->move($this->getParameter('annonce_pictures_directory'), $nomImg2); // déplace l'image dans le dossier adéquat
                    $annonce->setImg2($nomImg2);
                }
            $infoImg3 = $form['img3']->getData();
                if ($infoImg3 !== null) {
                    $extensionImg3 = $infoImg3->guessExtension();
                    $nomImg3 = time() . '-3.' . $extensionImg3;
                    $infoImg3->move($this->getParameter('annonce_pictures_directory'), $nomImg3);
                    $annonce->setImg3($nomImg3);
                }
            $infoImg4 = $form['img4']->getData();
                if ($infoImg4 !== null) {
                    $extensionImg4 = $infoImg4->guessExtension();
                    $nomImg4 = time() . '-4.' . $extensionImg4;
                    $infoImg4->move($this->getParameter('annonce_pictures_directory'), $nomImg4);
                    $annonce->setImg4($nomImg4);
                }    
            $entityManager->persist($annonce);
            $entityManager->flush();
            $this->addFlash('success', 'L\'image a bien été ajoutée');

            return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'annonce_show', methods: ['GET', 'POST'])] // Cf. Template "Annonce"
    public function show(Request $request, Annonce $annonce, NoteRepository $noteRepository, EntityManagerInterface $entityManager): Response
    {   
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
    
            $affichForm = true;
            if ($this->isGranted('ROLE_USER')) {
                if ($this->getUser()->getAnnonces()->contains($annonce) || $noteRepository->existsForUser($annonce, $this->getUser())) {
                    $affichForm = false;
                }
            }
            if ($form->isSubmitted() && $form->isValid()) {
                $note->setUtilisateur($this->getUser());
                $note->setAnnonce($annonce);
                $entityManager->persist($note);
                $entityManager->flush();
                
                return $this->redirectToRoute('annonce_show', ['id' => $annonce->getId()]);
            }

        return $this->renderForm('annonce/show.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
            'affichForm' => $affichForm
        ]);

        // $depositaire = $this->showAnnonceUser();
        // $this->getAnnonces()->getAnnonceUser()->contains($annonce);
        // $depositaire->showAnnonceUser($annonce);

    // public function getAnnonceUser(): ?User
    // {
    //     return $this->annonceUser;
    // }    
    
    //     public function getAnnonces(): Collection
    // {
    //     return $this->annonces;
    // }
    }

    #[Route('/{id}/edit', name: 'annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, EntityManagerInterface $entityManager, int $id, AnnonceRepository $annonceRepository): Response
    {
        $annonce = $annonceRepository->find($id); // ajouté sur modèle maison
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $infoImg1 = $form['img1']->getData(); // récupère l'img1 dans le formulaire
            $nomOldImg1 = $annonce->getImg1(); // récupère le nom de l'ancienne img1
            if ($infoImg1 !== null) { // vérifie s'il y a une img1 dans le formulaire
                $cheminOldImg1 = $this->getParameter('annonce_pictures_directory') . '/' . $nomOldImg1; // récupère l'ancienne image dans le directory des images
                if (file_exists($cheminOldImg1)) {
                    unlink($cheminOldImg1); // supprime l'ancienne img1
                }
                $nomImg1 = time() . '-1.' . $infoImg1->guessExtension(); // reconstitue le nom de la nouvelle img1
                $annonce->setImg1($nomImg1); // définit le nom de l'img1 de l'objet Annonce
                $infoImg1->move($this->getParameter('annonce_pictures_directory'), $nomImg1); // upload
            } else {
            $annonce->setImg1($nomOldImg1); // redéfinit le nom de l'mg1 à mettre en bdd
            }
        
            $infoImg2 = $form['img2']->getData(); // idem
            $nomOldImg2 = $annonce->getImg2(); // récupère le nom de l'ancienne img2
            if ($infoImg2 !== null) { // si on a une img2 dans le formulaire
                if ($nomOldImg2 !== null) { // si on a une img2 en bdd
                    $cheminOldImg2 = $this->getParameter('annonce_pictures_directory') . '/' . $nomOldImg2;
                    if (file_exists($cheminOldImg2)) {
                        unlink($cheminOldImg2);
                    }
                }
            $nomImg2 = time() . '-2.' . $infoImg2->guessExtension(); // reconstitue le nom de la nouvelle img2
            $annonce->setImg2($nomImg2); // définit le nom de l'img2 de l'objet Annonce
            $infoImg2->move($this->getParameter('annonce_pictures_directory'), $nomImg2);
            } else { // si on n'a pas d'img2 dans le formulaire
                $annonce->setImg2($nomOldImg2);
            }
            
            $infoImg3 = $form['img3']->getData(); // idem
            $nomOldImg3 = $annonce->getImg3(); // récupère le nom de l'ancienne img3
            if ($infoImg3 !== null) { // si on a une img3 dans le formulaire
                if ($nomOldImg3 !== null) { // si on a une img3 en bdd
                    $cheminOldImg3 = $this->getParameter('annonce_pictures_directory') . '/' . $nomOldImg2;
                    if (file_exists($cheminOldImg3)) {
                        unlink($cheminOldImg3);
                    }
                }
            $nomImg3 = time() . '-3.' . $infoImg3->guessExtension(); // reconstitue le nom de la nouvelle img3
            $annonce->setImg3($nomImg3); // définit le nom de l'img3 de l'objet Annonce
            $infoImg3->move($this->getParameter('annonce_pictures_directory'), $nomImg3);
            } else { // si on n'a pas d'img3 dans le formulaire
                $annonce->setImg3($nomOldImg3);
            }
                
            $infoImg4 = $form['img4']->getData(); // idem
            $nomOldImg4 = $annonce->getImg4(); // récupère le nom de l'ancienne img4
            if ($infoImg4 !== null) { // si on a une img4 dans le formulaire
                if ($nomOldImg4 !== null) { // si on a une img4 en bdd
                    $cheminOldImg4 = $this->getParameter('annonce_pictures_directory') . '/' . $nomOldImg4;
                    if (file_exists($cheminOldImg4)) {
                        unlink($cheminOldImg4);
                    }
                }
            $nomImg4 = time() . '-4.' . $infoImg4->guessExtension(); // reconstitue le nom de la nouvelle img4
            $annonce->setImg4($nomImg4); // définit le nom de l'img4 de l'objet Annonce
            $infoImg4->move($this->getParameter('annonce_pictures_directory'), $nomImg4);
            } else { // si on n'a pas d'img4 dans le formulaire
            $annonce->setImg4($nomOldImg4);
            }

            $entityManager->flush();
            // $manager = $managerRegistry->getManager();
            // $manager->persist($house);
            // $manager->flush();
            $this->addFlash('success', 'L\'annonce a bien été modifiée');
            return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
        
        }
        return $this->renderForm('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form
        ]);
        
    }
    
    #[Route('/{id}', name: 'annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository, int $id, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $annonce = $annonceRepository->find($id);
            // throw new \Exception('TODO: gérer la suppression des types du dossier img');
            $img1 = $this->getParameter('annonce_pictures_directory') . '/' . $annonce->getImg1();
            $img2 = $this->getParameter('annonce_pictures_directory') . '/' . $annonce->getImg2();
            $img3 = $this->getParameter('annonce_pictures_directory') . '/' . $annonce->getImg3();
            $img4 = $this->getParameter('annonce_pictures_directory') . '/' . $annonce->getImg4();
            if ($annonce->getImg1() && file_exists($img1)) {
                unlink($img1);
            }
            if ($annonce->getImg2() && file_exists($img2)) {
                unlink($img2);
            }
            if ($annonce->getImg3() && file_exists($img3)) {
                unlink($img3);
            }
            if ($annonce->getImg4() && file_exists($img4)) {
                unlink($img4);
            }
            $entityManager->remove($annonce);
            $entityManager->flush();
            $this->addFlash('success', 'L\'annonce a bien été supprimée');
        }

        return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
    }
}
