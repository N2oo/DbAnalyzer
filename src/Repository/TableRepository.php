<?php

namespace App\Repository;

use App\Entity\Table;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Table>
 *
 * @method Table|null find($id, $lockMode = null, $lockVersion = null)
 * @method Table|null findOneBy(array $criteria, array $orderBy = null)
 * @method Table[]    findAll()
 * @method Table[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Table::class);
    }

    /**
     * @return Table[]
     */
    public function findByTabIds(array $ids):array
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.tabId IN (:idlist)')
            ->setParameter('idlist',$ids)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Table[]
     */
    public function findByFilenames(array $fileNames){
        return $this->createQueryBuilder('t')
        ->select('t')
        ->where('t.dbFileName IN (:fileNameList)')
        ->setParameter('fileNameList',$fileNames)
        ->getQuery()
        ->getResult();
    }

    /**
     * @param Table[] $tables
     */
    public function hydrateTables(array $tables){
        return $this->createQueryBuilder('t')
            ->select('t,c,i,d,do')
            ->leftJoin('t.columns','c')
            ->leftJoin('t.indexes','i')
            ->leftJoin('t.dependencies','d')
            ->leftJoin('t.dependOns','do')
            ->where('t IN (:tableList)')
            ->setParameter('tableList',$tables)
            ->getQuery()
            ->getResult();
    }

    public function findByOwners(array $owners)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('t');
        return $this->getQBOwnerInList($queryBuilder,$owners)
            ->getQuery()
            ->getResult();
    }

    public function findByLikelyTableName(string $likelyName){
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('t');
        return $this
            ->getQBLikelyTableName($queryBuilder,$likelyName)
            ->getQuery()
            ->getResult();
    }

    public function findByLikelyTableNameAndInOwnerList(array $owners,string $likelyName)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('t');
        $queryBuilder = $this->getQBLikelyTableName($queryBuilder,$likelyName);
        return $this
            ->getQBOwnerInList($queryBuilder,$owners)
            ->getQuery()
            ->getResult();
    }

    private function getQBLikelyTableName(QueryBuilder $queryBuilder,string $likelyName):QueryBuilder
    {
        return $queryBuilder->andWhere('t.tableName LIKE :input')
        ->setParameter('input',"%{$likelyName}%");
    }

    private function getQBOwnerInList(QueryBuilder $queryBuilder,array $owners):QueryBuilder
    {
        return $queryBuilder
            ->andWhere('t.owner in (:ownerlist)')
            ->setParameter('ownerlist',$owners);
    }

//    /**
//     * @return Table[] Returns an array of Table objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Table
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
