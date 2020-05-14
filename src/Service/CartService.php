<?php

namespace App\Service;

use App\Repository\AdRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    /**
     * Permet de sécuriser le paiement
     *
     * @var Security
     */
    private $security;

    /**
     * Donne accès aux informations concernant la session d'un utilisateur 
     *
     * @var SessionInterface
     */
    private $session;

    /**
     * Le dépôt des réservations
     *
     * @var BookingRepository
     */
    private $bookingRepository;

    /**
     * Le manager de Doctrine qui nous permet notamment de trouver le repository dont on a besoin
     *
     * @var EntityManagerInterface
     */
    private $manager;
    
    /**
     * Constructeur du service de paiement qui sera appelé par Symfony
     *
     * @param SessionInterface $session
     * @param Security $security
     * @param BookingRepository $bookingRepository  
     * @param EntityManagerInterface $manager
     */
    public function __construct(SessionInterface $session, Security $security, BookingRepository $bookingRepository, EntityManagerInterface $manager)
    {
        $this->session = $session;
        $this->security = $security;
        $this->bookingRepository = $bookingRepository;
        $this->manager = $manager;
    }

    /**
     * Pour ajouter une réservation d'annonce au panier 
     *
     * @param integer $id
     * @return void
     */
    public function add(int $id) : void
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    /**
     * Pour supprimer une réservation d'annonce au panier 
     *
     * @param integer $id
     * @return void
     */
    public function remove(int $id): void
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    /**
     * Recevoir les informations relatives à un utilisateur et selon sa réservation 
     *
     * @return array
     */
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

    /**
     * Connaitre le total du panier 
     *
     * @return float
     */
    public function getTotal(): float
    {
        $total = 0;


        foreach ($this->getFullCart() as $item) {

            if ($item['booking']->getPayment() == false) {
                $total += $item['booking']->getAmount();
            }
        }

        return $total;
    }

    /**
     * Evite les doublons dans le panier
     * 
     * @param integer $id
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
     * @param integer $id
     * @return boolean
     */
    public function PaymentIsWaiting($id): bool
    {
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
    public function GetPaymentWithStripe(): void
    {
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_Gkb9vQtFUJoMRRu8whbUszAn00GYXF5MHT');
        $token = $_POST['stripeToken'];
        $charge = \Stripe\Charge::create([
            'amount' => ($this->getTotal()) * 100,
            'currency' => 'eur',
            'description' => 'Example charge',
            'source' => $token,
        ]);
    }

    /**
     * Modifie le statut du paiement de false à true une fois la réservation payée
     * 
     * @return avoid
     */
    public function ChangeOfPaymentStatus(): void
    {
        foreach ($this->getFullCart() as $item) {
            $item['booking']->setPayment(true);
            $this->manager->persist($item['booking']);
            $this->manager->flush();
        }
    }

    /**
     * Vide la session du panier une fois que le paiement est validé 
     * 
     * @return avoid
     */
    public function UnsetPanier(): void
    {
        unset($_SESSION['_sf2_attributes']['panier']);
    }
}
