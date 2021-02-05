<?php

namespace App\Repository;

use App\Entity\Contart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contart[]    findAll()
 * @method Contart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contart::class);
    }

    // /**
    //  * @return Contart[] Returns an array of Contart objects
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

    /*
    public function findOneBySomeField($value): ?Contart
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
