<?php

namespace App\Repository;

use App\Entity\DependOn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DependOn>
 *
 * @method DependOn|null find($id, $lockMode = null, $lockVersion = null)
 * @method DependOn|null findOneBy(array $criteria, array $orderBy = null)
 * @method DependOn[]    findAll()
 * @method DependOn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DependOnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DependOn::class);
    }

//    /**
//     * @return DependOn[] Returns an array of DependOn objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DependOn
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
