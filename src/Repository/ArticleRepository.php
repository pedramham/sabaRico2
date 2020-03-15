<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }
    public function finById(int $id){
        return $this->createQueryBuilder('a')
            ->Leftjoin('App:CategoryArticle', 'c','with','c.id = a.idCategory' )
            ->select('a.name','a.urlSlug','a.title','a.id','a.description','a.subject','a.dateInsert','a.largePic',
                'a.descriptionSeo','a.labelKeyWord','a.authorName','a.lastUpdate',
                'c.id as idCategory','c.urlSlug as CategoryUrlSlug','c.name as nameCategory')
            ->where('a.id = :id')
            ->andWhere('a.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->setParameter('id', $id)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            ->setResultCacheId('Article××−−By××Id×××−1')
          //  ->useResultCache(true, 2000)
            ->getResult();
    }
    public function findByLimit(string $order,int $limit)
    {
        return $this->createQueryBuilder('a')
            ->select('a.name','a.urlSlug','a.title','a.id')
            ->andWhere('a.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->orderBy('a.'.$order, 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            ->setResultCacheId('Article××−−By××Limit×××−2')
          //  ->useResultCache(true, 600)
            ->getResult();
    }

    public function findByExceptId(int $id,int $limit)
    {
        return $this->createQueryBuilder('a')
            ->select('a.name','a.urlSlug','a.title','a.id')
            ->andWhere('a.id != :id')
            ->setParameter('id', $id)
            ->orderBy('a.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            ->setResultCacheId('Article××−−By××Except×××id−3')
       //     ->useResultCache(true, 600)
            ->getResult();
    }
    public function findByExceptIdCategory(int $Id = null,int $limit =null)
    {
        return $this->createQueryBuilder('a')
            ->select('a.name','a.smallPic','a.title','a.subject','a.id','a.urlSlug')
            ->andWhere('a.idCategory != :idCategory')
            ->setParameter('idCategory', $Id)
            ->orderBy('a.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            ->setResultCacheId('Article××−−By××Except×××id××××cat−3')
         //   ->useResultCache(true, 600)
            ->getResult();
    }


    /**
     *
     *
     * @return Article[] Returns an array of Article objects
     */
    public function findByRelateArticle( $IdCategory = null,$id = null,$limit =null )
    {
        return $this->createQueryBuilder('a')
            ->select('a.name','a.smallPic','a.title','a.subject','a.id','a.urlSlug','a.dateInsert')
            ->Where('a.idCategory = :idCategory')
            ->andWhere('a.id != :id')
            ->setParameter('idCategory', $IdCategory)
            ->setParameter('id', $id)
            ->orderBy('a.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            ->setResultCacheId('Category××−−1Article')
        //    ->useResultCache(true, 600)
            ->getResult();
    }

}
