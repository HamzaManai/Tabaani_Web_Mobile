<?php

namespace App\Repository;
use App\Entity\InfluenceurSearch;
use App\Entity\Influenceur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Influenceur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Influenceur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Influenceur[]    findAll()
 * @method Influenceur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfluenceurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Influenceur::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Influenceur $entity, bool $flush = true): void
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
    public function remove(Influenceur $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Influenceur[] Returns an array of Influenceur objects
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
    public function findOneBySomeField($value): ?Influenceur
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
     /**
     * @return Influenceur[] Returns an array of Influenceur objects
     */
    
    public function findEntitiesByString($nom,$code,$facebookPage,$instagramPage): ?array
    {
        try {
            return $this->createQueryBuilder('i')
            ->andWhere('i.nom = :nom') 
            ->setParameter('nom',$nom)
            ->andWhere('i.code = :code')
            ->setParameter('code',$code)
            ->andWhere('i.facebookPage = :facebookPage')
              ->setParameter('facebookPage',$facebookPage)
              ->andWhere('i.instagramPage = :instagramPage')
              ->setParameter('instagramPage',$instagramPage)
              ->setMaxResults(10)
            ->getQuery()
            ->getResult()
             ;
         }catch (NonUniqueResultException $e) {
        return null;
    }

    
    }
    public function findEntitiesByNom($nom): ?array
    {
        try {
            return $this->createQueryBuilder('i')
            ->andWhere('i.nom = :nom') 
            ->setParameter('nom',$nom)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
             ;
         }catch (NonUniqueResultException $e) {
        return null;
    }}
    public function findEntitiesBycodeA($nom,$code): array
    {
        try {
            $qb=$this->createQueryBuilder('i');
            if ($code!=""){
                $qb->andWhere('i.code = :code')
                ->setParameter('code',$code);
            }
            if ($nom!=""){
                $qb->andWhere('i.nom = :nom') 
                 ->setParameter('nom',$nom); 
             }   
            $query=$qb->getQuery();
            return $query->execute();
        
           
         }catch (NonUniqueResultException $e) {
        return null;
    }}
    public function findEntitiesBycode($nom,$code,$facebookPage,$instagramPage,$email)
    {
        try {
            $qb=$this->createQueryBuilder('i')
            ->Where('1 =1');
            if ($nom!=""){
                $qb->andWhere('i.nom LIKE :searchTerms') 
                 ->setParameter('searchTerms','%'.$nom.'%'); 
             }  
             if ($code!=""){
              $qb->andWhere('i.code LIKE :code')
                ->setParameter('code','%'.$code.'%');
            } 
            if ($facebookPage!=""){
                $qb->andWhere('i.facebookPage LIKE :facebookPage') 
                 ->setParameter('facebookPage','%'.$facebookPage.'%'); 
             }  
             if ($instagramPage!=""){
                
                $qb->andWhere('i.instagramPage LIKE :searchTerm') 
                 ->setParameter('searchTerm','%'.$instagramPage.'%'); 
             } 
             if ($email!=""){
                
                $qb->andWhere('i.email LIKE :searchTer') 
                 ->setParameter('searchTer','%'.$email.'%'); 
             }  
            $query=$qb->getQuery();
           
            return $query->execute();
        
           
         }catch (NonUniqueResultException $e) {
        return null;
    }}
}
