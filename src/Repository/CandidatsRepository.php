<?php

namespace App\Repository;

use App\Entity\Candidats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Candidats|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidats|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidats[]    findAll()
 * @method Candidats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidats::class);
    }

    // /**
    //  * @return Candidats[] Returns an array of Candidats objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Candidats
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
