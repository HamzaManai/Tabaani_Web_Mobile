<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Commentaire $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Commentaire $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

  
    



    // /**
    //  * @return Commentaire[] Returns an array of Commentaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneBySomeField($value): ?Commentaire
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findAllorder()
    {
        return $this->findBy(array(), array('dateComment' => 'desc'));
    }
    
    /**
    * @return Commentaire[] Returns an array of Influenceur objects
    */
    
    public function findComment($id): ?array
    {
        try {
            $qb=$this->createQueryBuilder('u')
            ->Where('1 =1');
            if ($id!=""){
                $qb->andWhere('u.Blog = :id')
                 ->setParameter('id', $id);
      
             }  
            $query=$qb->getQuery();
           
            return $query->execute();        
           
         }
         catch (NonUniqueResultException $e)
          {
         return null;
         }
    }
    public function findAccountComment($id)
    {
    try {
            $qb=$this->createQueryBuilder('u');
            return $qb
                  ->select('count(u.id)')
                  ->Where('u.Blog = :id')
                  ->setParameter('id', $id)
                  ->getQuery()
                  ->getOneOrNullResult()
              ;
      
         }         
         
         catch (NonUniqueResultException $e)
          {
          return null;
         }
    }
    public function findEntitiesBycode($nom,$id,$comment,$mail)
    {
        try {
            $qb=$this->createQueryBuilder('i')
            ->Where('1 =1');
            if ($nom!=""){
                $qb->andWhere('i.nom LIKE :searchTerms') 
                 ->setParameter('searchTerms','%'.$nom.'%'); 
             }  
             if ($id!=""){
              $qb->andWhere('i.id LIKE :id')
                ->setParameter('id','%'.$id.'%');
            } 
            if ($mail!=""){
                $qb->andWhere('i.mail LIKE :mail') 
                 ->setParameter('mail','%'.$mail.'%'); 
             }  
             if ($comment!=""){
                
                $qb->andWhere('i.comment LIKE :comment') 
                 ->setParameter('comment','%'.$comment.'%'); 
             }  
            $query=$qb->getQuery();
           
            return $query->execute();
        
           
         }catch (NonUniqueResultException $e) {
        return null;
    }}
}
