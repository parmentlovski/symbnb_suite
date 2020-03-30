<?php

namespace App\Controller;


use App\Service\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService)
    {
        
        $cartService->getFullCart();

        $cartService->getTotal();
        
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart() , 
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService ){

       $cartService->add($id);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * Permet de supprimer un produit
     *  @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService){
        $cartService->remove($id);

        return $this->redirectToRoute("cart_index");
    }
}
