<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
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
     * Permet de télécharger une page HTML en PDF
     *
     * @param integer $id
     * @param string $fileName
     * @param string $templatePath
     * @param string $templateParams
     * 
     * @return void
     */
    public function download(string $fileName, string $templatePath, array $templateParams = null)
    {
        // Instanciation et configuration de Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // Initialisation des options
        $dompdf = new Dompdf($pdfOptions);

        // $booking = $this->manager->getRepository($this->entityClass)->find($id);

        $html = $this->renderView($templatePath, $templateParams);

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