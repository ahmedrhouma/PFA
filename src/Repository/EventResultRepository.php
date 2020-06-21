<?php

namespace App\Repository;

use App\Entity\EventResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EventResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventResult[]    findAll()
 * @method EventResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventResult::class);
    }

    // /**
    //  * @return EventResult[] Returns an array of EventResult objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventResult
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
