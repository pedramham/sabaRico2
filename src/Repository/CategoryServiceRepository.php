<?php

namespace App\Repository;

use App\Entity\CategoryService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryService|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryService|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryService[]    findAll()
 * @method CategoryService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryService::class);
    }
//    public function findByLimit(array $criteria, array $orderBy = null, $limit = null, $offset = null)
//    {
//        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);
//
//        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
//    }
    public function findByLimit($order,$limit)
    {
        return $this->createQueryBuilder('c')
            ->select('c.name','c.urlSlug','c.title','c.id')
            ->andWhere('c.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->orderBy('c.'.$order, 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
//            ->useResultCache(true, 600)
            ->setResultCacheId('categoryService−×××−−×1')
            ->getResult();
    }
}
