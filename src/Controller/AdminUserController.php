<?php

namespace App\Controller;

use App\Entity\User;
use League\Csv\Writer;
use App\Service\ExportCsvService;
use App\Repository\UserRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * Permet d'afficher la liste des utilisateurs
     * 
     * @Route("/admin/users/{page<\d+>?1}", name="admin_user_index")
     * 
     * @param integer $page
     * @param PaginationService $pagination
     * 
     * @return  Response
     */
    public function index($page, PaginationService $pagination, UserRepository $repo)
    {

        $pagination->setEntityClass(User::class)
            ->setPage($page);

        $export = 'admin_user_exportcsv';

        return $this->render('admin/user/index.html.twig', [
            'pagination' => $pagination,
            'export' => $export
        ]);
    }

    /**
     * Permet d'exporter les données en fichier csv
     *
     * @Route("/admin/user/exportcsv", name="admin_user_exportcsv")
     *
     * @return Response
     */
    public function exportCsv(ExportCsvService $exportCsv, EntityManagerInterface $manager, UserRepository $userRepo)
    {
        $users = $userRepo->findAll();
        $exportCsv->createCsv(
            [
                'Prénom',
                'Nom',
                'Email',
                "Nombre d'annonces",
                "Nombre de réservations"
            ]
        );

        foreach ($users as $user) {
            $exportCsv->insertCsv([
                $user->getFirstName(),
                $user->getLastName(),
                $user->getEmail(),
                count($user->getAds()),
                count($user->getBookings())
            ]);
        }

        $exportCsv->getOutput('users.csv');

        exit;
    }

    /**
     * Permet de supprimer un utilisateur
     * 
     * @Route("/admin/user/{id}/delete", name="admin_user_delete")
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * 
     * @return Response
     */
    public function delete(User $user, EntityManagerInterface $manager)
    {

        if (count($user->getAds()) > 0 || count($user->getBookings()->slice(0)) > 0) {
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer l'utilisateur <strong>{$user->getFullName()}</strong> car il déjà posté / réservé des annonces !"
            );
        } else {

            $manager->remove($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'utilisateur <strong>{$user->getFullName()}</strong> a bien été supprimé !"
            );
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
