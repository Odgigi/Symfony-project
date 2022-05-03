<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Annonce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    
    #[Route('/cart', name: 'cart')]
    public function index(Cart $cart): Response
    {
        $cartComplete = [];

        foreach ($cart->get() as $id => $quantity) {
            $cartComplete[] = [
                'annonce' => $this->entityManager->getRepository(Annonce::class)->findOneById($id),
                'quantity' => $quantity
            ];
        }
        
        return $this->render('cart/index.html.twig', [
            'cart' => ($cartComplete)
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('annonce_index');
    }

    #[Route('/cart/delete/{id}', name: 'delete_in_cart')]
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('annonce_index');
    }
}