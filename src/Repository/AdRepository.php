<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    public function findBestAds($limit)
    {

        return $this->createQueryBuilder('a')
            ->select('a as annonce,  AVG(c.rating) as avgRatings')
            ->join('a.comments', 'c')
            ->groupBy('a')
            ->orderBy('avgRatings', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function search($criteria)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.city = :ville')
            ->setParameter('ville', $criteria['ville'])
            ->andWhere('a.rooms >= :minChambres')
            ->setParameter('minChambres', $criteria['minChambres'])
            ->andWhere('a.rooms <= :maxChambres')
            ->setParameter('maxChambres', $criteria['maxChambres'])
            ->andWhere('a.price >= :minimumPrice')
            ->setParameter('minimumPrice', $criteria['minimumPrice'])
            ->andWhere('a.price <= :maximumPrice')
            ->setParameter('maximumPrice', $criteria['maximumPrice'])
            ->getQuery()
            ->getResult();
    }



    // /**
    //  * @return Ad[] Returns an array of Ad objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.price > :minPrice')
            ->setParameter('minPrice', $criteria['minPrice'])
            ->andWhere('a.price < :maxPrice')
            ->setParameter('maxPrice', $criteria['maxPrice'])
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Ad
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
