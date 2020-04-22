<?php

namespace App\Controller;

use App\Service\CartService;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        if ($cartService->isAlreadyInCart($id) == false) {
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

    /**
     * Payement d'une réservation
     *
     * @Route("/payement", name="cart_payement")
     * 
     * @return Response
     */
    public function payment(Request $request)
    {

        $form = $this->get('form.factory')
            ->createNamedBuilder('payment-form')
            ->add('token', HiddenType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('submit', SubmitType::class)
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                // TODO: charge the card
            }
        }

        return $this->render('cart/payement.html.twig', [
            'form' => $form->createView(),
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
        ]);

        return $this->render('cart/payement.html.twig');
    }
}
