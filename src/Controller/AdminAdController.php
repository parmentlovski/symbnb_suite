<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use League\Csv\Writer;
use App\Repository\AdRepository;
use App\Service\ExportCsvService;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * Permet d'afficher la liste des annonces
     * 
     * @Route("/admin/ads/{page<\d+>?1}", name="admin_ads_index")
     * 
     * @param interger $page
     * @param PaginationService $pagination
     * 
     * @return Response
     */
    public function index($page, PaginationService $pagination)
    {

        $pagination->setEntityClass(Ad::class)
            ->setPage($page);

        $export = 'admin_ads_exportcsv';

        return $this->render('admin/ad/index.html.twig', [
            'pagination' => $pagination,
            'export' => $export
        ]);
    }

    /**
     * Permet d'exporter les données en fichier csv
     *
     * @Route("/admin/ads/exportcsv", name="admin_ads_exportcsv")
     *
     * @return Response
     */
    public function exportCsv(ExportCsvService $exportCsv, EntityManagerInterface $manager)
    {
        $ads = $manager->getRepository(Ad::class)->findAll();
        $exportCsv->createCsv(
            [
                'Titre', 
                'Auteur', 
                'Nombre de réservations', 
                'Note'
            ]
        );

        foreach ($ads as $ad) {
            $exportCsv->insertCsv([
                $ad->getTitle(),
                $ad->getAuthor()->getFirstName() . " " . $ad->getAuthor()->getLastName(),
                count($ad->getBookings()),
                $ad->getAvgRating()
            ]);
        }

        $exportCsv->getOutput('annonces.csv');

        exit;
    }

    /**
     * Permet d'afficher le formulaire d'édition
     *
     * @Route("/admin/ads/{id}/edit", name="admin_ads_edit")
     * 
     * @param Ad $ad
     * @return Response
     */
    public function edit(Ad $ad, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistré"
            );
        }

        return $this->render('admin/ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     *
     * @Route("/admin/ads/{id}/delete", name="admin_ads_delete")
     * 
     * @param Ad $ad
     * @param EntityManagerInterface $manager
     * 
     * @return Response
     */
    public function delete(Ad $ad, EntityManagerInterface $manager)
    {
        if (count($ad->getBookings()) > 0) {
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer l'annonce <strong>{$ad->getTitle()}</strong> car elle possède déjà des réservations !"
            );
        } else {

            $manager->remove($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce {$ad->getTitle()} a bien été supprimée !"
            );
        }

        return $this->redirectToRoute('admin_ads_index');
    }
}
