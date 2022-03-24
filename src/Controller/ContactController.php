<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    #[Route('/contact/success', name: 'contact_success')]
    public function success(): Response
    {
        return $this->render('contact/success.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class); // On utilise un createForm pour mettre en place le formulaire de contact qui s'affichera dans contact_index
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // vérification - ou envoi - du formulaire
            // Envoyer un mail depuis le formulaire (Cf. symfony mailer:https://symfony.com/doc/current/mailer.html )
            $data = $form->getData();
            $email = (new Email())
            ->from($data['email']) // adresse du visiteur
            ->to('admin@oggies.go.yj.fr') // notre adresse admin de réception
            ->subject($data['subject']) // objet du mail
            ->text($data['message']) // corps du mail
            ->html($data['message']); // corps du mail en html

        $mailer->send($email);
            return $this->redirectToRoute('contact_success', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form
        ]);
    }
}
