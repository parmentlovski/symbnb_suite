<?php

namespace App\Service;

use App\Entity\Booking;
use App\Repository\AdRepository;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class CartService
{

    private $security;

    public function __construct(SessionInterface $session, AdRepository $adRepository, Security $security, BookingRepository $bookingRepository)
    {
        $this->session = $session;
        $this->adRepository = $adRepository;
        $this->security = $security;
        $this->bookingRepository = $bookingRepository;
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
                // 'ad' => $this->adRepository->find($id),
                'booking' => $this->bookingRepository->find($id),
                'quantity' => $quantity,
                'user' => $user
            ];
        }
        // dd($panierWithData);

        return $panierWithData;
    }

    public function getTotal(): float
    {
        $total = 0;



        foreach ($this->getFullCart() as $item) {
            $total += $item['booking']->getAmount();
        }

        return $total;
    }

    public function isAlreadyInCart($id)
    {
        $booking =  $this->bookingRepository->find($id);

        foreach ($this->getFullCart() as $item) {
            // dump($item['booking']->getStartDate());
            // dump($item['booking']->getEndDate());
            // dump($booking->getStartDate());
            // dump($booking->getEndDate());
            // dump($item['booking']);

            if ($item['booking']->getId() == $booking->getId() && $booking->getStartDate() <= $item['booking']->getStartDate() && $booking->getStartDate() <= $item['booking']->getEndDate()) {

                // dd('Pas possible');
                return true;
            } else {
                // dd("Possible");
                return false;
            }
        }
    }
}
