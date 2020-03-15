<?php

namespace App\Repository;

use App\Entity\CategoryArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryArticle[]    findAll()
 * @method CategoryArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryArticle::class);
    }

    public function findByLimit($order,$limit)
    {
        return $this->createQueryBuilder('a')
            ->select('a.name','a.urlSlug','a.title','a.id','a.smallPic','a.subject','a.dateInsert','a.smallPic','a.descriptionSeo')
            ->andWhere('a.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->orderBy('a.'.$order, 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
//            ->useResultCache(true, 600)
            ->setResultCacheId('CategoryArticle×××−−×1')
            ->getResult();
    }

}
