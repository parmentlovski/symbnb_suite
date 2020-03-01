<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeneratePdfService extends AbstractController
{
    /**
     * Le nom de l'entité sur laquelle on veut utiliser
     *
     * @var string
     */
    private $entityClass;

    /**
     * Le chemin vers le template qui contient la page à transformer en PDF
     *
     * @var string
     */
    private $templatePath;

    /**
     * Le manager de Doctrine qui nous permet notamment de trouver le repository dont on a besoin
     *
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * Constructeur du service de PDF qui sera appelé par Symfony
     * 
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        // Autres initialisations
        $this->manager      = $manager;
    }


    public function download(int $id, string $templatePath, string $fileName)
    {

        // Instanciation et configuration de Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Initialisation des options
        $dompdf = new Dompdf($pdfOptions);

        $booking = $this->manager->getRepository($this->entityClass)->find($id);

        $html = $this->renderView($templatePath, [
            'booking' => $booking,
            'ad' => $booking->getAd()
        ]);

        // dd($this->entityClass);

        // Chargement du PDF dans Dompdf
        $dompdf->loadHtml($html);

        // Rendu du HTML en PDF
        $dompdf->render();

        // Génération du PDF et téléchargement sur l'espace local
        $dompdf->stream($fileName . ".pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * Permet de spécifier l'entité sur laquelle on souhaite travailler
     * Par exemple :
     * - App\Entity\Ad::class
     * - App\Entity\Comment::class
     *
     * @param string $entityClass
     * @return self
     */
    public function setEntityClass(string $entityClass): self
    {
        $this->entityClass = $entityClass;
        return $this;
    }
}
