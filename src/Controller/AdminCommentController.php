<?php

namespace App\Controller;

use League\Csv\Writer;
use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Service\ExportCsvService;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * Permet d'afficher la liste des commentaires
     * 
     * @Route("/admin/comments/{page<\d+>?1}", name="admin_comments_index")
     *
     *@param interger $page
     * @param PaginationService $pagination
     * 
     * @return Response
     */
    public function index($page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Comment::class)
            ->setPage($page);
        $export = 'admin_comments_exportcsv';

        return $this->render('admin/comment/index.html.twig', [
            'pagination' => $pagination,
            'export' => $export
        ]);
    }
    
    /**
     * Permet d'exporter les données en fichier csv
     *
     * @Route("/admin/comments/exportcsv", name="admin_comments_exportcsv")
     *
     * @return Response
     */
    public function exportCsv(ExportCsvService $exportCsv, EntityManagerInterface $manager)
    {
        $comments = $manager->getRepository(Comment::class)->findAll();
        $exportCsv->createCsv([
            'Date', 
            'Auteur', 
            'Commentaire', 
            'Note', 
            'Annonce']
        );

        foreach ($comments as $comment) {
            $exportCsv->insertCsv([
                $comment->getCreatedAt()->format('Y-m-d H:i:s'),
                $comment->getAuthor()->getFirstName() . " " . $comment->getAuthor()->getLastName(),
                $comment->getContent(),
                $comment->getRating(),
                $comment->getAd()->getTitle()
            ]);
        }

        $exportCsv->getOutput('commentaires.csv');

        exit;
    }

    /**
     * Permet de modifier un commentaire 
     * 
     * @Route("/admin/comment/{id}/edit", name="admin_comments_edit")
     *
     * @param Comment $comment
     * @param Request $request
     * @param EntityManagerInterface $manager
     * 
     * @return Response
     */
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager)
    {

        $form = $this->createForm(AdminCommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le commentaire n° <strong>{$comment->getId()}</strong> a bien été modifié"
            );
        }

        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer un commentaire
     * 
     * @Route("/admin/comment/{id}/delete", name="admin_comments_delete")
     *
     * @param EntityManagerInterface $manager
     * @param Comment $comment
     * 
     * @return Response
     */
    public function delete(EntityManagerInterface $manager, Comment $comment)
    {
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le commentaire n°<strong>{$comment->getId()}</strong> a bien été supprimé"
        );

        return $this->redirectToRoute("admin_comment_index");
    }
}
