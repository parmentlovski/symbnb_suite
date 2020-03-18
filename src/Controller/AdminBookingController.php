<?php

namespace App\Controller;


use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Service\PaginationService;
use App\Service\ExportCsvService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{

    /**
     * Permet d'afficher la liste des réservations
     * 
     * @Route("/admin/bookings/{page<\d+>?1}", name="admin_bookings_index")
     * 
     * @param PaginationService $pagination
     * @param integer $page
     * 
     * @return Response
     */
    public function index(PaginationService $pagination, $page)
    {

        $pagination->setEntityClass(Booking::class)
            ->setPage($page);

        $export = 'admin_bookings_exportcsv';

        return $this->render('admin/booking/index.html.twig', [
            'pagination' => $pagination,
            'export' => $export
        ]);
    }

    /**
     * Permet d'exporter les données en fichier csv
     *
     * @Route("/admin/bookings/exportcsv", name="admin_bookings_exportcsv")
     *
     * @return Response
     */
    public function exportCsv(ExportCsvService $exportCsv, EntityManagerInterface $manager)
    {
        $bookings = $manager->getRepository(Booking::class)->findAll();
        $exportCsv->createCsv(
            [
                'Date',
                'Visiteur',
                'Annonce',
                'Prix'
            ]
        );

        foreach ($bookings as $booking) {
            $exportCsv->insertCsv(
                [
                    $booking->getCreatedAt()->format('Y-m-d H:i:s'),
                    $booking->getBooker()->getFirstName() . " " . $booking->getBooker()->getLastName(),
                    $booking->getAd()->getTitle(),
                    $booking->getAmount() . " €"
                ]
            );
        }

        $exportCsv->getOutput('reservations.csv');

        exit;
    }

    /**
     * Permet de modifier une réservation 
     * 
     * @Route("/admin/booking/{id}/edit", name="admin_bookings_edit")
     *
     * @return Response
     */
    public function edit(Booking $booking, Request $request, EntityManagerInterface $manager)
    {

        $form = $this->createForm(AdminBookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $booking->setAmount(0);

            $manager->persist($booking);
            $manager->flush();

            $this->addFlash(
                'success',
                "La réservation n°{$booking->getId()} a bien été modifiée !"
            );

            return $this->redirectToRoute("admin_bookings_index");
        }

        return $this->render('admin/booking/edit.html.twig', [
            'form' => $form->createView(),
            'booking' => $booking
        ]);
    }
    /**
     * Permet de supprimer une réservation
     * 
     * @Route("/admin/booking/{id}/delete", name="admin_bookings_delete")
     *
     * @param EntityManagerInterface $manager
     * @param Booking $booking
     * 
     * @return Response
     */
    public function delete(EntityManagerInterface $manager, Booking $booking)
    {
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            "La réservation a bien été supprimé"
        );

        return $this->redirectToRoute("admin_bookings_index");
    }
}
