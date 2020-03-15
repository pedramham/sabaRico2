<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }
    public function finById($id){
        return $this->createQueryBuilder('s')
            ->Leftjoin('App:CategoryService', 'c','with','c.id = s.idCategory' )
            ->select('s.name','s.urlSlug','s.title','s.id','s.description','s.subject','s.dateInsert','s.largePic','c.labelKeyWord','c.descriptionSeo',
                'c.id as idCategory','c.urlSlug as CategoryUrlSlug','c.name as nameCategory')
            ->where('s.id = :id')
            ->andWhere('s.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->setParameter('id', $id)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
//            ->useResultCache(true, 600)
            ->setResultCacheId('Service×By*××id−−×1')
            ->getResult();
    }
    public function findByLimit($order,$limit)
    {
        return $this->createQueryBuilder('s')
            ->select('s.name','s.urlSlug','s.title','s.id','s.subject','s.smallPic','s.authorName','s.dateInsert')
            ->andWhere('s.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->orderBy('s.'.$order, 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
           // ->useResultCache(true, 600)
           ->setResultCacheId('Service×By*××limit−−××2')
            ->getResult();
    }
     /**
      * @return Service[] Returns an array of Service objects
      */
    public function findByRelateService($IdCategory = null,$id = null,$limit =null )
    {
        return $this->createQueryBuilder('s')
            ->select('s.name','s.smallPic','s.title','s.subject','s.id','s.urlSlug','s.dateInsert')
            ->Where('s.idCategory = :idCategory')
            ->andWhere('s.id != :id')
            ->setParameter('idCategory', $IdCategory)
            ->setParameter('id', $id)
            ->orderBy('s.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            // ->useResultCache(true, 600)
            ->setResultCacheId('Service×By*××relate−−×××3')
            ->getResult();
    }
}
