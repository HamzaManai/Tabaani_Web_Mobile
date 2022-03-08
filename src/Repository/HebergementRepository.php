<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Entity\Hebergement;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @method Hebergement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hebergement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hebergement[]    findAll()
 * @method Hebergement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HebergementRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Hebergement::class);
        $this->paginator = $paginator;
    }

    // /**
    //  * @return Hebergement[] Returns an array of Hebergement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hebergement
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /*
    public function findType($type)
    {
        $q=$this->createQueryBuilder('H')
            ->where('H.type_hbrg = :type')
            ->setParameter('type',$type);

        return $q->getQuery()->getResult();
    }
    */
    /**
     * Récupère les hebergements en lien avec une recherche
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function findSearch(SearchData $search): \Knp\Component\Pager\Pagination\PaginationInterface
    {

        $query = $this
            ->createQueryBuilder('h')
            ->select('t', 'h')
            ->leftJoin('h.type_hbrg', 't')
            ->leftJoin('h.proprietaire', 'p');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('h.nom_hbrg LIKE :h')
                ->setParameter('h', "%{$search->q}%");
        }

        if (!empty($search->type_hbrg)) {
            $query = $query
                ->andWhere('h.type_hbrg = :t')
                ->setParameter('t', $search->type_hbrg);
        }

        if (!empty($search->nbr_place)) {
            $query = $query
                ->andWhere('h.nbr_place_hbrg = :n')
                ->setParameter('n', $search->nbr_place);
        }

        if (!empty($search->adresse_hbrg)) {
            $query = $query
                ->andWhere('h.adresse_hbrg LIKE :a')
                ->setParameter('a', "%{$search->adresse_hbrg}%");
        }
        if (!empty($search->date_hbrg)) {
            $query = $query
                ->andWhere('h.date_hbrg = :d')
                ->setParameter('d', $search->date_hbrg);
        }

        if (!empty($search->proprietaire)) {
            $query = $query
                ->andWhere('h.proprietaire = :p')
                ->setParameter('p', $search->proprietaire);
        }


        if (!empty($search->min)) {
            $query = $query
                ->andWhere('h.prix_hbrg >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->max)) {
            $query = $query
                ->andWhere('h.prix_hbrg <= :max')
                ->setParameter('max', $search->max);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            3
        );
    }

        /**
     * Récupère les hebergements en lien avec une recherche
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function findSearchFront(SearchData $search): \Knp\Component\Pager\Pagination\PaginationInterface
    {
        $time = new \DateTime();
        $todays = $time->format('Y-m-d');

        $query = $this
            ->createQueryBuilder('h')
            ->select('t', 'h')
            ->leftJoin('h.type_hbrg', 't')
            ->leftJoin('h.proprietaire', 'p')
            ->where ('h.date_hbrg >= '."'".$todays."'")
            ->andWhere('h.nbr_place_hbrg > 0');


        if (!empty($search->q)) {
            $query = $query
                ->andWhere('h.nom_hbrg LIKE :h')
                ->setParameter('h', "%{$search->q}%");
        }

        if (!empty($search->type_hbrg)) {
            $query = $query
                ->andWhere('h.type_hbrg = :t')
                ->setParameter('t', $search->type_hbrg);
        }

        if (!empty($search->nbr_place)) {
            $query = $query
                ->andWhere('h.nbr_place_hbrg = :n')
                ->setParameter('n', $search->nbr_place);
        }

        if (!empty($search->adresse_hbrg)) {
            $query = $query
                ->andWhere('h.adresse_hbrg LIKE :a')
                ->setParameter('a', "%{$search->adresse_hbrg}%");
        }
        if (!empty($search->date_hbrg)) {
            $query = $query
                ->andWhere('h.date_hbrg = :d')
                ->setParameter('d', $search->date_hbrg);
        }

        if (!empty($search->proprietaire)) {
            $query = $query
                ->andWhere('h.proprietaire = :p')
                ->setParameter('p', $search->proprietaire);
        }


        if (!empty($search->min)) {
            $query = $query
                ->andWhere('h.prix_hbrg >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->max)) {
            $query = $query
                ->andWhere('h.prix_hbrg <= :max')
                ->setParameter('max', $search->max);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            3
        );
    }


    /**
     * Récupère les hebergements en lien avec un utilisateur
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function findByUser($id): \Knp\Component\Pager\Pagination\PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('h')
           //  ->leftJoin('h.Utilisateur','u')
           // ->where('u.id = :id')
            ->Where('h.user = :id')
            ->orWhere('h.proprietaire = :id')
            ->setParameter('id', $id);

            $query = $query->getQuery();
            return $this->paginator->paginate(
                $query
            );
            }





}
