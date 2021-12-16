<?php

namespace App\Repository;

use App\Entity\Fetiche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fetiche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fetiche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fetiche[]    findAll()
 * @method Fetiche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeticheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fetiche::class);
    }

    // /**
    //  * @return Fetiche[] Returns an array of Fetiche objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fetiche
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
