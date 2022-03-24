<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{
    #[Route('/', name: 'annonce_index', methods: ['GET'])] // Cf. Template "Toutes les annonces" Attention bien rentrer '/' dans le navigateur et non '/index' qui renvoie vers une (fausse) erreur "Param Converter"
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
    public function show(Request $request, Annonce $annonce, NoteRepository $NoteRepository, EntityManager $EntityManager): Response
    {   
        // ajouter un formulaire NoteType: création
        dd($NoteRepository->existsForUser($annonce, $this->getUser()));
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
            // dans template (ou directement dans Controller) gérer User connecté (is_granted en twig{% if is_granted('IS_AUTHENTICATED_FULLY') %}/isGranted en php) + pas déjà mis note sur annonce + annonce d'autre utilisateur    
            // SELECT * FROM Note WHERE USER_id = : id_user AND annonce_id =: id_annonce
            
            if ($this->getUser()->getAnnonces()->contains($annonce)) {
            }
            if ($form->isSubmitted() && $form->isValid()) {
                $annonce->addNote($note);
                $this->getUser()->addNote($note);
                $entityManager->persist($note);
                $entityManager->flush();
            }

                // !$annonce->contains($annonce) && $this->isGranted($user) && (!$note->getUtilisateur() === $this)
                // insérer la nouvelle note en bdd
                // $annonce->addNote($note); ?
                // $this->getUser()->addNote($note);

                /*
                    MOYENNE DES NOTES
                    - récupérer les notes ($annonce->getNotes())
                    - calculer la moyenne des notes
                    (- autres calculs si nécessaire)
                    - envoyer la note à la vue
                */
                $notes = $annonce->getNotes();
                
                // $sommeNotesInsolite = 0;
                // $sommeNotesPratique = 0;
                // $sommeNotesStyle = 0;
                $moyennesGlobales = [];
                foreach ($notes as $note) {
                    // $sommeNotesInsolite += $note->getNoteInsolite();
                    // $sommeNotesPratique += $note->getNotePratique();
                    // $sommeNotesStyle += $note->getNoteStyle();
                    $moyenneGlobale = ($note->getNoteInsolite() + $note->getNotePratique() + $note->getNoteStyle()) / 3;
                    array_push($moyennesGlobales, $moyenneGlobale);
                }
                $noteGlobaleMin = 0;
                $noteGlobaleMoyenne = array_sum($moyennesGlobales) / count($moyennesGlobales);
                $noteGlobaleMax = 0;
                // nouvelle_moyenne = (( ancienne_moyenne * ancien_nb_note) + nouvelle_note) / (ancien_nb_vote+1);

                // calculs pour les priux
                // insertion des nouveauxprix en bdd dans la tbale anoonce
                
                return $this->redirectToRoute('annonce_show');
    
        
        // gestion du formulaire (insertion dans la table `note` + calcul du nouveau prix et envoi en bdd dans la table `annonce`):  
        
        // envoi du formulaire

        
        return $this->renderForm('annonce/show.html.twig', [
            'annonce' => $annonce,
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit', name: 'annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
    }
}
