<?php

namespace App\Repository;

use App\Entity\OperatingHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OperatingHistory>
 *
 * @method OperatingHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperatingHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperatingHistory[]    findAll()
 * @method OperatingHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperatingHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperatingHistory::class);
    }

    //    /**
    //     * @return OperatingHistory[] Returns an array of OperatingHistory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OperatingHistory
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
