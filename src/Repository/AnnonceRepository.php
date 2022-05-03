<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Annonce;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function findFetichedAnnonce()
    {
        return $this->createQueryBuilder('f')
            ->innerJoin('f.feticheUsers','u')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Requête qui permet de récupérer les annonces en fonction de la recherche de l'utilisateur
     * @return Annonce[]
     */
    public function findWithSearch(Search $search)
    {
        $query = $this
        ->createQueryBuilder('a')
        ->select('c', 'a')
        ->join('a.categorie', 'c');

        if (!empty($search->categories)) {
            $query = $query
            ->andWhere('c.id IN (:categories)')
            ->setParameter('categories', $search->categories);
        }

        if (!empty($search->string)) {
            $query = $query
            ->andWhere('a.titre LIKE :string')
            ->setParameter('string', "%$search->string%");
        }

        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLastSix()
    {
        return $this->createQueryBuilder('ad') // ad est un alias
            ->orderBy('ad.id', 'DESC') // tri par odre décroissant
            ->setMaxResults(6) // on sélectionne 6 résultats
            ->getQuery() // construit la requête
            ->getResult() // exécute - récupère le(s) résultat(s)
        ;
    }

    public function trouverSixDerniers()
    {
        $bdd = $this->getEntityManager()->getConnection();
        $req = $bdd->query('SELECT * FROM annonce ORDER BY id DESC LIMIT 6');
        // $req->executeQuery();
        return $req->fetchAllAssociative();
    }
}
