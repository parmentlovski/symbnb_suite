<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * Affiche les différentes réservations dont le paiement n'a pas été effectué
     * 
     * @Route("/panier", name="cart_index")
     * 
     * @param CartService $cartService
     * 
     * @return Response
     */
    public function index(CartService $cartService)
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * Permet d'ajouter un produit
     * 
     * @Route("/panier/add/{id}", name="cart_add")
     * 
     * @param Request $request
     * @param CartService $cartService
     * 
     * @return Response
     */
    public function add($id, CartService $cartService)
    {
        if ($cartService->isAlreadyInCart($id) == false && $cartService->PaymentIsWaiting($id) == true) {
            $cartService->add($id);

            $this->addFlash(
                'success',
                "Votre réservation a bien été ajoutée à votre panier"
            );
        } else if ($cartService->isAlreadyInCart($id) == false && $cartService->PaymentIsWaiting($id) == false) {
            $this->addFlash(
                'danger',
                "Votre réservation à déja été payée"
            );

            return $this->redirectToRoute("account_bookings");
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
     * 
     *  @Route("/panier/remove/{id}", name="cart_remove")
     * 
     * @param integer $id
     * @param CartService $cartService
     * 
     * @return Response
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * Paiement d'une réservation
     *
     * @Route("/paiement", name="cart_payment")
     * 
     * @param Request $request
     * @param CartService $cartService
     * 
     * @return Response
     */
    public function payment(Request $request, CartService $cartService)
    {

        $form = $this->get('form.factory')
            ->createNamedBuilder('payment-form')
            ->add('token', HiddenType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('Payer', SubmitType::class)
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);


            if ($form->isSubmitted()) {

                $cartService->GetPaymentWithStripe();
                $cartService->ChangeOfPaymentStatus();
                $cartService->UnsetPanier();

                $this->addFlash(
                    'success',
                    "Le paiement à été accepté"
                );
            } else {
                $this->addFlash(
                    'warning',
                    "Il y'a une erreur"
                );
            }
        }

        return $this->render('cart/payment.html.twig', [
            'form' => $form->createView(),
            'bookings' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()

        ]);
    }
}
