<?php

namespace App\Repository;

use App\Entity\Content;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Content|null find($id, $lockMode = null, $lockVersion = null)
 * @method Content|null findOneBy(array $criteria, array $orderBy = null)
 * @method Content[]    findAll()
 * @method Content[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Content::class);
    }
     /**
      * @return Content[] Returns an array of Content objects
      */
    public function findByLimit($order,$limit)
    {
        return $this->createQueryBuilder('c')
            ->select('c.name','c.urlSlug','c.title','c.id','c.subject','c.smallPic')
            ->andWhere('c.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->orderBy('c.'.$order, 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
           // ->useResultCache(true, 600)
            ->setResultCacheId('Content−×××−−3×5')
            ->getResult();
    }
}
