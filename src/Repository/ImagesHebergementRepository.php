<?php

namespace App\Repository;

use App\Entity\ImagesHebergement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImagesHebergement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagesHebergement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagesHebergement[]    findAll()
 * @method ImagesHebergement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesHebergementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagesHebergement::class);
    }

    // /**
    //  * @return ImagesHebergement[] Returns an array of ImagesHebergement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImagesHebergement
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
