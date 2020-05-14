<?php

namespace App\Service;

use League\Csv\Writer;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Cette classe permet d'exporter des données sql en fichier csv 
 */
class ExportCsvService
{

    /**
     * Le nom de l'entité sur laquelle on veut effectuer une pagination
     *
     * @var string
     */
    private $entityClass;

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
        $this->csv = Writer::createFromString('');
    }
    
     /**
     * Permet de spécifier l'entité sur laquelle on souhaite paginer
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
    /**
     * Permet de récupérer l'entité sur laquelle on est en train de paginer
     *
     * @return string
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

     /**
     * Permet de récupérer les données paginées pour une entité spécifique
     * 
     * Elle se sert de Doctrine afin de récupérer le repository pour l'entité spécifiée
     * puis grâce au repository et à sa fonction findBy() on récupère les données dans une 
     * certaine limite et en partant d'un offset
     * 
     * @throws Exception si la propriété $entityClass n'est pas définie
     *
     * @return array
     */
    public function getData()
    {
        if (empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devons paginer ! Utilisez la méthode setEntityClass() de votre objet PaginationService !");
        }
        // 1) Demander au repository de trouver tout les éléments
        return $this->manager
            ->getRepository($this->entityClass)
            ->findAll();
    }
    
      /**
     * Permet de créer un fichier csv et d'inclure un header
     * 
     * @return avoid
     */
    public function createCsv($header): void
    {
        $this->csv->insertOne($header);
    }

    /**
     * Permet d'insérer les données d'une entité quelconque 
     * 
     * @return avoid
     */
    public function insertCsv($insert): void
    {
        $this->csv->insertOne($insert);
    }

    /**
     * Permet de récupérer le nom de fichier d'export csv
     * 
     * @return avoid
     */
    public function getOutput($output): void
    {
        $this->csv->output($output);
    }

}


