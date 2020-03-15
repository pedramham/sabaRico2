<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
    public function finById($id){
        return $this->createQueryBuilder('p')
            ->Leftjoin('App:CategoryProduct', 'c','with','c.id = p.idCategoryProduct' )
            ->select('p.name','p.urlSlug','p.title','p.id','p.description','p.subject','p.dateInsert','p.smallPic','p.price','p.discount','p.labelKeyWord','p.descriptionSeo',
                'p.manufacturingCountry','p.productCode','p.brand','p.sellerTelephone','p.guarantee','p.periodGuarantee',
                'c.id as idCategory','c.urlSlug as CategoryUrlSlug','c.name as nameCategory')
            ->where('p.id = :id')
            ->andWhere('p.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->setParameter('id', $id)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            //->useResultCache(true, 600)
            ->setResultCacheId('Product−××id×−−1×')
            ->getResult();
    }

    public function findByLimit($order,$limit)
    {
        return $this->createQueryBuilder('p')
            ->select('p.name','p.urlSlug','p.title','p.id','p.subject','p.smallPic','p.price','p.discount')
            ->andWhere('p.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->orderBy('p.'.$order, 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
//            ->useResultCache(true, 600)
            ->setResultCacheId('Product−××limit×−−2×')
            ->getResult();
    }
    public function findByExceptId(int $id,int $limit)
    {
        return $this->createQueryBuilder('c')
            ->select('c.name','c.urlSlug','c.title','c.id')
            ->andWhere('c.id != :id')
            ->setParameter('id', $id)
            ->orderBy('c.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            ->useResultCache(true, 600)
            ->setResultCacheId('Product−××except×−−3×')
            ->getResult();
    }
}
