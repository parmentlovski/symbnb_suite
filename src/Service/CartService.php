<?php 

namespace App\Service ;

use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService{

    public function __construct(SessionInterface $session, AdRepository $adRepository)
    {
        $this->session = $session;
        $this->adRepository = $adRepository;
    }

    public function add(int $id){
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;
        }
        else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function remove(int $id) {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);

    }

    public function getFullCart() : array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'ad' => $this->adRepository->find($id),
                'quantity' => $quantity
            ];

        }

        return $panierWithData;
    }

    public function getTotal() : float {
        $total = 0;

        foreach($this->getFullCart() as $item) {
            $total += $item['ad']->getPrice() * $item['quantity'];
        }

        return $total;
    }

}