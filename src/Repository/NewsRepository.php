<?php

namespace App\Repository;
use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository  extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }
    public function finById($id){
        return $this->createQueryBuilder('n')
            ->Leftjoin('App:CategoryNews', 'c','with','c.id = n.idCategory' )
            ->select('n.name','n.urlSlug','n.title','n.id','n.description','n.subject','n.dateInsert','n.largPic','n.descriptionSeo','n.labelKeyWord','n.authorName',
                'c.id as idCategory','c.urlSlug as CategoryUrlSlug','c.name as nameCategory')
            ->where('n.id = :id')
            ->andWhere('n.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->setParameter('id', $id)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            ->setResultCacheId('News××−by−××id×1')
//            ->useResultCache(true, 10)
            ->getResult();
    }
    public function findByLimit($order,$limit)
    {
        return $this->createQueryBuilder('n')
            ->select('n.name','n.urlSlug','n.title','n.id','n.subject','n.smallPic')
            ->andWhere('n.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->orderBy('n.'.$order, 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            ->setResultCacheId('News××−by−××Limit××2')
//            ->useResultCache(true, 10)
            ->getResult();
    }


    /**
     * @return News[] Returns an array of News objects
     */
    public function findByRelateNews($IdCategory = null,$id = null,$limit =null )
    {
        return $this->createQueryBuilder('n')
            ->select('n.name','n.smallPic','n.title','n.subject','n.id','n.urlSlug','n.dateInsert')
            ->Where('n.idCategory = :idCategory')
            ->andWhere('n.id != :id')
            ->setParameter('idCategory', $IdCategory)
            ->setParameter('id', $id)
            ->orderBy('n.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            ->setResultCacheId('News××−by−××relate×××3')
//            ->useResultCache(true, 10)
            ->getResult();
    }
}
