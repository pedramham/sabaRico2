<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }
    public function findByLimit(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
    }
    public function findByIdCategory(int $idCategory,string $nameEntity)
    {
        return $this->createQueryBuilder('c')
            ->select('c.name','c.subject','c.nameAdmin','c.answerAdmin')
            ->andWhere('c.'.$nameEntity.' = :id')
            ->setParameter('id', $idCategory)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
//            ->expireQueryCache(true)
//            ->useQueryCache(true)
//            ->useResultCache(true, 5000)
            ->getResult();
    }
}
