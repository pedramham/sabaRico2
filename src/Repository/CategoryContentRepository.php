<?php

namespace App\Repository;

use App\Entity\CategoryContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryContent[]    findAll()
 * @method CategoryContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryContent::class);
    }
}
