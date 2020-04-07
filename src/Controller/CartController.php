<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Service\CartService;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService, BookingRepository $repo, Security $security)
    {

        $cartService->getFullCart();

        $cartService->getTotal();

        $book = $repo->findBookingByBooker($security->getUser());

        // dd($book);

        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'book' => $book
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService)
    {
        if ($cartService->isAlreadyInCart($id) == true) {
            $cartService->add($id);
        } else {
            $this->addFlash(
                'danger',
                "Cette réservation est déjà dans votre panier"
            );

            return $this->redirectToRoute("account_bookings");
        }


        return $this->redirectToRoute("cart_index");
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
