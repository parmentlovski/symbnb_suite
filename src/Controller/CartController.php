<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Service\CartService;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_Gkb9vQtFUJoMRRu8whbUszAn00GYXF5MHT');

class CartController extends AbstractController
{
    /**
     * Affiche les différentes réservations dont le paiement n'a pas été effectué
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService, Security $security, BookingRepository $repo)
    {

        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * Permet d'ajouter un produit
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService)
    {
        if ($cartService->isAlreadyInCart($id) == false && $cartService->PaymentIsWaiting($id) == true) {
            $cartService->add($id);

            $this->addFlash(
                'success',
                "Votre réservation a bien été ajoutée à votre panier"
            );
        }
        
        else if ($cartService->isAlreadyInCart($id) == false && $cartService->PaymentIsWaiting($id) == false){
            $this->addFlash(
                'danger',
                "Votre réservation à déja été payée"
            );

            return $this->redirectToRoute("account_bookings");
        }
        
        else {
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

    /**
     * Paiement d'une réservation
     *
     * @Route("/paiement", name="cart_payment")
     * 
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
                $cartService->SetAndClearPanier();

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
