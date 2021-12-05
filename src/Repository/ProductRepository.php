<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
    /**
     * Requête  qui me permet de récuperer les produits en fonction de la recherche de l'utilisateur
     * @return Product[]
     */
    public function findWithSearch(Search $search)
    {
        $query = $this
        -> createQueryBuilder('p')
        ->select('c','p')
        ->join('p.category', 'c');

        if (!empty($search->categories)){
            $query 
            ->andWhere('c.id IN (:categories)')
            ->setParameter('categories',$search->categories);
        }

        if (!empty($search->typeOffre)){

            $query->andWhere('p.typeOffre = :typeOffre')
            ->setParameter('typeOffre',$search->typeOffre);
        }

        if (!empty($search->string)){
            $query 
            ->andWhere('p.name LIKE :string')
            ->setParameter('string', "%{$search->string}%");
        }

        if (!empty($search->prixMin)){
            $query 
            ->andWhere('p.prix >= :prixMin')
            ->setParameter('prixMin',$search->prixMin);
        }

        if (!empty($search->prixMax)){
            $query 
            ->andWhere('p.prix <= :prixMax')
            ->setParameter('prixMax',$search->prixMax);
        }

        //dd($query->getQuery()->getSQL());

        return $query->getQuery()->getResult();

    }
    

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
