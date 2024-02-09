<?php

namespace App\Repository;

use App\Entity\Detail;
use App\Entity\Table;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Detail>
 *
 * @method Detail|null find($id, $lockMode = null, $lockVersion = null)
 * @method Detail|null findOneBy(array $criteria, array $orderBy = null)
 * @method Detail[]    findAll()
 * @method Detail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Detail::class);
    }

    /**
     * @return Detail[]
     */
    public function findByTabId(Table $table)
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->where('d.tableElement = :table')
            ->setParameter('table',$table)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Detail[]
     */
    public function findByOriginalTableId(Table $table)
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->leftJoin('d.tableElement','t')
            ->where('t.tabId = :tabId')
            ->setParameter('tabId',$table->getTabId())
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Detail[] $details
     */
    public function hydrate(array $details)
    {
        return $this->createQueryBuilder('d')
            ->select('d,u')
            ->leftJoin('d.users','u')
            ->where('d IN (:detailList)')
            ->setParameter('detailList',$details)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Detail[] Returns an array of Detail objects
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

//    public function findOneBySomeField($value): ?Detail
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
