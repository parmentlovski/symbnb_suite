<?php

namespace App\Service;

use App\Entity\Booking;
use App\Repository\AdRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    private $security;

    public function __construct(SessionInterface $session, AdRepository $adRepository, Security $security, BookingRepository $bookingRepository, EntityManagerInterface $manager)
    {
        $this->session = $session;
        $this->adRepository = $adRepository;
        $this->security = $security;
        $this->bookingRepository = $bookingRepository;
        $this->manager = $manager;
    }

    public function add(int $id)
    {
        $panier = $this->session->get('panier', []);

   
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);

        $user = $this->security->getUser();

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'booking' => $this->bookingRepository->find($id),
                'quantity' => $quantity,
                'user' => $user
            ];
        }

        return $panierWithData;
    }

    public function getTotal(): float
    {
        $total = 0;


        foreach ($this->getFullCart() as $item) {

            if($item['booking']->getPayment() == false) {
                $total += $item['booking']->getAmount();
            }
        }

        return $total;
    }

    /**
     * Evite les doublons dans le panier
     * @return boolean
     */
    public function isAlreadyInCart($id)
    {
        $booking =  $this->bookingRepository->find($id);

        foreach ($this->getFullCart() as $item) {

            if ($item['booking']->getId() == $booking->getId() && $booking->getStartDate() <= $item['booking']->getStartDate() && $booking->getStartDate() <= $item['booking']->getEndDate()) {

                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Permet de savoir si la réservation de l'utilisateur a déjà été payé
     * 
     */
    public function PaymentIsWaiting($id){

        $booking =  $this->bookingRepository->find($id);


            if ($booking->getPayment() == false) {

                // dd('Pas possible');
                return true;
            } else {
                // dd("Possible");
                return false;
            }
    }
   

    /**
     * Permet de réaliser le paiement avec Stripe 
     * 
     * @return avoid
     */
    public function GetPaymentWithStripe(){
        $token = $_POST['stripeToken'];
        $charge = \Stripe\Charge::create([
            'amount' => ($this->getTotal())*100,
            'currency' => 'eur',
            'description' => 'Example charge',
            'source' => $token,
        ]);
    }

    /**
     * Permet de modifier le statut du paiement de false à true
     * 
     * @return avoid
     */
    public function ChangeOfPaymentStatus(){
       
        foreach ($this->getFullCart() as $id => $item) {
            $item['booking']->setPayment(true);
             $this->manager->persist($item['booking']);
             $this->manager->flush();
         }
    }

    /**
     * Vider la session du panier une fois que le paiement est validé 
     * 
     * @return avoid
     */
     public function SetAndClearPanier(){
        unset($_SESSION['_sf2_attributes']['panier']);
     }

}
