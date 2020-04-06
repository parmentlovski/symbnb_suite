<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\CommentType;
use App\Service\CartService;
use App\Service\GeneratePdfService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{

    /**
     * @Route("/ads/{slug}/book/{id}", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Ad $ad, Request $request, EntityManagerInterface $manager, $id, CartService $cartService)
    {
        $booking = new Booking();
        $user = $this->getUser();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $booking->setBooker($user)
                ->setAd($ad);

            // Si les dates ne sont pas disponibles, message d'erreur
            if (!$booking->isBookableDates()) {
                $this->addFlash(
                    'warning',
                    'Les dates que vous avez choisi ne peuvent être réservées: elles sont déjà prises.'
                );
            } else {
                // Sinon enregistrement et redirection
                $manager->persist($booking);
                $manager->flush();
                // $cartService->add($id);

                // $this->addFlash(
                //     'success',
                //     "Votre réservation pour l'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrer !"
                // );

                return $this->redirectToRoute('booking_show', [
                    'id' => $booking->getId(),
                    'success' => true
                ]);
            }
        }

        return $this->render('booking/book.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher la page d'une réservation
     *
     * @Route("/booking/{id}", name="booking_show")
     * 
     * @param Booking $booking
     * @param Request $request
     * @param EntityManagerInterface $manager
     * 
     * @return Response
     */
    public function show(Booking $booking, Request $request, EntityManagerInterface $manager)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAd($booking->getAd())
                ->setAuthor($this->getUser()); // $this->getUser() nous renvoie l'utilisateur connecté 

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre commentaire a bien été pris en compte !'
            );
        }

        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier une réservation 
     * 
     * @Route("/booking/{id}/edit", name="booking_edit")
     *
     * @return Response
     */
    public function edit(Booking $booking, Request $request, EntityManagerInterface $manager)
    {

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $booking->setAmount(0);

            $manager->persist($booking);
            $manager->flush();

            $this->addFlash(
                'success',
                "La réservation n°{$booking->getId()} a bien été modifiée !"
            );

            return $this->redirectToRoute('booking_show', [
                'id' => $booking->getId(),
                'success' => true
            ]);
        }

        return $this->render('booking/edit.html.twig', [
            'form' => $form->createView(),
            'booking' => $booking,
        ]);
    }

    /**
     * Permet de télécharger la facture en pdf
     * 
     * @Route("/booking/{id}/download", name="booking_pdf")
     * 
     * @param Booking $id
     * @param GeneratePdfService $pdf
     *
     * @return void
     */
    public function donwloadBookingPDF(Booking $id, GeneratePdfService $pdf)
    {
        // On renseigne l'entité relié au PDF
        $pdf->setEntityClass(Booking::class);

        //download prend en parametre :
        // le nom du fichier à télécharger
        // le chemin du template twig
        // et les paramettre de ce template
        $pdf->download("reservation_" . $id->getId(), 'download/booking.html.twig', [
            'booking' => $id,
            'ad' => $id->getAd()
        ]);
    }

    /**
     * Permet d'annuler une réservation
     * 
     * @Route("/booking/{id}/delete", name="booking_delete")
     *
     * @param Booking $booking
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Booking $booking, EntityManagerInterface $manager)
    {
        $id = $booking->getId();
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            "La réservation " . $id . " a bien été supprimé"
        );

        return $this->redirectToRoute("account_bookings");
    }
}
