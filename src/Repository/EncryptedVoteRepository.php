<?php

namespace App\Repository;

use App\Entity\EncryptedVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EncryptedVote|null find($id, $lockMode = null, $lockVersion = null)
 * @method EncryptedVote|null findOneBy(array $criteria, array $orderBy = null)
 * @method EncryptedVote[]    findAll()
 * @method EncryptedVote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EncryptedVoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EncryptedVote::class);
    }

    // /**
    //  * @return EncryptedVote[] Returns an array of EncryptedVote objects
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
    public function findOneBySomeField($value): ?EncryptedVote
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
