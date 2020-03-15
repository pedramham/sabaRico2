<?php

namespace App\Repository;

use App\Entity\ImageGallery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ImageGallery|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageGallery|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageGallery[]    findAll()
 * @method ImageGallery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageGalleryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageGallery::class);
    }
//    public function findByLimit(array $criteria, array $orderBy = null, $limit = null, $offset = null)
//    {
//        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);
//
//        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
//    }
    public function findByLimit($type,$idCategory)
    {
        return $this->createQueryBuilder('i')
            ->select('i.name','i.alt','i.title','i.file','i.subject')
            ->where('i.'.$type.' = :idCategory')
            ->andWhere('i.displayStatus = :displayStatus')
            ->setParameter('displayStatus', 1)
            ->setParameter('idCategory', $idCategory)
            ->orderBy('i.displayPriority', 'DESC')
            ->getQuery()
            ->expireQueryCache(true)
            ->useQueryCache(true)
            ->setResultCacheId('imageGallery*××find−−×××3')
            ->getResult();
    }
}
