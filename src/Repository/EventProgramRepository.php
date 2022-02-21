<?php

namespace App\Repository;

use App\Entity\EventProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventProgram|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventProgram|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventProgram[]    findAll()
 * @method EventProgram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventProgram::class);
    }

    // /**
    //  * @return EventProgram[] Returns an array of EventProgram objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventProgram
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
