<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function add($id)
    {
        $cart = $this->getSession->get('cart', []);

        // if (!empty($cart[$id])) {
        //     $cart[$id]++;
        // } else {
        //     $cart[$id] = 1;
        // }

        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function get()
    {
        return $this->requestStack->getSession()->get('cart');
    }

    public function remove()
    {
        return $this->requestStack->getSession()->remove('cart');
    }

    public function delete($id)
    {
        $cart = $this->getSession->get('cart', []);
        unset($cart[$id]);
        return $cart;
    }

}