<?php

namespace App\Repository;

use App\Entity\ReminderWater;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReminderWater>
 *
 * @method ReminderWater|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReminderWater|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReminderWater[]    findAll()
 * @method ReminderWater[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReminderWaterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReminderWater::class);
    }

//    /**
//     * @return ReminderWater[] Returns an array of ReminderWater objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReminderWater
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
