<?php

namespace App\Repository;

use App\Entity\Column;
use App\Entity\Table;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Column>
 *
 * @method Column|null find($id, $lockMode = null, $lockVersion = null)
 * @method Column|null findOneBy(array $criteria, array $orderBy = null)
 * @method Column[]    findAll()
 * @method Column[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColumnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Column::class);
    }

    public function findByTableAndColumnNo(Table $table,array $columns)
    {
        return $this->createQueryBuilder("c")
            ->select('c')
            ->where('c.tableElement = :table')
            ->setParameter('table',$table)
            ->andWhere('(c.columnNumber = :part1 OR c.columnNumber = :part2 OR c.columnNumber = :part3 OR c.columnNumber = :part4 OR c.columnNumber = :part5 OR c.columnNumber = :part6 OR c.columnNumber = :part7 OR c.columnNumber = :part8)')
            ->setParameter('part1',$columns[0])
            ->setParameter('part2',$columns[1])
            ->setParameter('part3',$columns[2])
            ->setParameter('part4',$columns[3])
            ->setParameter('part5',$columns[4])
            ->setParameter('part6',$columns[5])
            ->setParameter('part7',$columns[6])
            ->setParameter('part8',$columns[7])
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Column[] Returns an array of Column objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Column
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
