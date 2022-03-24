<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;
    /**
     * @param $entityManager
     */

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/compte/mot-de-passe', name: 'account_password')]
    public function index(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager): Response
    {
        $notification = null;
        
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPwd = $form->get('oldPassword')->getData();
            
            if ($hasher->isPasswordValid($user, $oldPwd)) {
                $newPwd = $form->get('newPassword')->getData();
                $password = $hasher->hashPassword($user, $newPwd);
                
                $user->setPassword($password);
                $entityManager->flush();
                $notification = "Votre mot de passe a bien été mis à jour.";
            } else {
                $notification = "Votre mot de passe actuel n'est pas le bon.";
            }
        }
        
        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
