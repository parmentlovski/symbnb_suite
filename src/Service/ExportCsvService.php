<?php

namespace App\Service;

use App\Entity\Ad;
use App\Entity\User;
use League\Csv\Writer;
use App\Entity\Booking;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Cette classe permet d'exporter des données sql en fichier csv 
 */
class ExportCsvService
{

    /**
     * Le manager de Doctrine qui nous permet notamment de trouver le repository dont on a besoin
     *
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * Constructeur du service de pagination qui sera appelé par Symfony
     * 
     *  @param ObjectManager $manager
     */

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

     /**
     * Permet d'exporter les données concernant les annonces
     *
     * @return void
     */
    public function loadCsvAds(){
        $ads = $this->manager->getRepository(Ad::class)->findAll();
        $header = ['Titre', 'Auteur', 'Nombre de réservations', 'Note'];

        //load the CSV document from a string
        $csv = Writer::createFromString('');

        //insert the header
        $csv->insertOne($header);

        foreach ($ads as $ad) {
            $csv->insertOne([
                $ad->getTitle(),
                $ad->getAuthor()->getFirstName() . " " . $ad->getAuthor()->getLastName(),
                count($ad->getBookings()),
                $ad->getAvgRating()
            ]);

        }

        $csv->output('annonces.csv');
    }

    /**
     * Permet d'exporter les données concernant les réservations
     *
     * @return void
     */
    public function loadCsvBookings()
    {
        $bookings = $this->manager->getRepository(Booking::class)->findAll();
        $header = ['Date', 'Visiteur', 'Annonce', 'Prix'];

        //load the CSV document from a string
        $csv = Writer::createFromString('');

        //insert the header
        $csv->insertOne($header);

        foreach ($bookings as $booking) {
            $csv->insertOne([
                $booking->getCreatedAt()->format('Y-m-d H:i:s'),
                $booking->getBooker()->getFirstName() . " " . $booking->getBooker()->getLastName(),
                $booking->getAd()->getTitle(),
                $booking->getAmount() . " €",
            ]);
        }

        $csv->output('reservations.csv');
    }

     /**
     * Permet d'exporter les données concernant les commentaires
     *
     * @return void
     */
    public function loadCsvComments(){
        $comments = $this->manager->getRepository(Comment::class)->findAll();
        $header = ['Date', 'Auteur', 'Commentaire', 'Note', 'Annonce'];
 
        //load the CSV document from a string
        $csv = Writer::createFromString('');

        //insert the header
        $csv->insertOne($header);

        foreach ($comments as $comment) {
            $csv->insertOne([
                $comment->getCreatedAt()->format('Y-m-d H:i:s'),
                $comment->getAuthor()->getFirstName() . " " . $comment->getAuthor()->getLastName(),
                $comment->getContent(),
                $comment->getRating(),
                $comment->getAd()->getTitle()
            ]);
        }

        $csv->output('commentaires.csv');
    }

     /**
     * Permet d'exporter les données concernant les utilisateurs
     *
     * @return void
     */
    public function loadCsvUsers(){
        $bookings = $this->manager->getRepository(User::class)->findAll();
        $header = ['Prénom', 'Nom', 'Email', "Nombre d'annonces", "Nombre de réservations"];

        //load the CSV document from a string
        $csv = Writer::createFromString('');

         //insert the header
         $csv->insertOne($header);

        foreach($bookings as $booking) {
            $csv->insertOne([
            $booking->getFirstName(),
            $booking->getLastName(),
            $booking->getEmail(),
            count($booking->getAds()),
            count($booking->getBookings())
            ]);
        }
    
        $csv->output('users.csv');
    }
}
