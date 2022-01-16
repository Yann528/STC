<?php

namespace App\Repository;

use App\Entity\Productimg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Productimg|null find($id, $lockMode = null, $lockVersion = null)
 * @method Productimg|null findOneBy(array $criteria, array $orderBy = null)
 * @method Productimg[]    findAll()
 * @method Productimg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductimgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Productimg::class);
    }

    // /**
    //  * @return Productimg[] Returns an array of Productimg objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Productimg
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
