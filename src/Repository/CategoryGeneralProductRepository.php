<?php

namespace App\Repository;

use App\Entity\CategoryGeneralProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryGeneralProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryGeneralProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryGeneralProduct[]    findAll()
 * @method CategoryGeneralProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryGeneralProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryGeneralProduct::class);
    }

    // /**
    //  * @return CategoryGeneralProduct[] Returns an array of CategoryGeneralProduct objects
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
    public function findOneBySomeField($value): ?CategoryGeneralProduct
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
