<?php

namespace App\Controller;

use App\Service\CartService;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
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
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService)
    {
        if ($cartService->isAlreadyInCart($id) == false) {
            $cartService->add($id);

            $this->addFlash(
                'success',
                "Votre réservation à bien été ajoutée à votre panier"
            );
        } else {
            $this->addFlash(
                'danger',
                "Cette réservation est déjà dans votre panier"
            );

            return $this->redirectToRoute("account_bookings");
        }


        return $this->redirectToRoute("account_bookings");
    }

    /**
     * Permet de supprimer un produit
     *  @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);

        return $this->redirectToRoute("cart_index");
    }
}
