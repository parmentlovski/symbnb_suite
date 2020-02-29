<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\CommentType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Dompdf\Options;

class BookingController extends AbstractController
{

    public function __construct(\Knp\Snappy\Pdf $knpSnappy)
    {
        $this->knpSnappy = $knpSnappy;
    }

    /**
     * @Route("/ads/{slug}/book", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Ad $ad, Request $request, EntityManagerInterface $manager)
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
     * @param Raquest $request
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
     * Permet de visualiser la facture en pdf
     * 
     * @Route("/booking/{id}/show_pdf", name="booking_pdf")
     *
     * @return PdfResponse
     */
    public function doanwloadBookingPDF(Booking $booking, BookingRepository $repo)
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('download/booking.html.twig', [
            'booking' => $repo->find($booking)
        ]);

        $html .= '<link type="text/css" href="/assets/css/app.scss" rel="stylesheet" />';
        $html .= '<link type="text/css" href="/assets/css/bootstrap.css" rel="stylesheet" />';

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * Fichier PDF
     * 
     * @Route("/booking/pdf", name="booking_pdfFile")
     *
     * @return Response
     */
    public function filePDF(BookingRepository $repo)
    {

        return $this->render("download/booking.html.twig", [
            'booking' => $repo->find('106')
        ]);
    }
}
