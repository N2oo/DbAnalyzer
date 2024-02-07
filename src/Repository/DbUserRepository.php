<?php

namespace App\Repository;

use App\Entity\DbUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DbUser>
 *
 * @method DbUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method DbUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method DbUser[]    findAll()
 * @method DbUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DbUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DbUser::class);
    }
    public function findByHomeFolders($homeFolders)
    {
        $builder = $this->createQueryBuilder('dbu')
        ->select('dbu');
        foreach($homeFolders as $key=>$homeFolder){
            $builder->orWhere("dbu.homeFolder LIKE :folder{$key}")
                ->setParameter("folder{$key}","{$homeFolder}%");
        }
        return $builder
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return DbUser[] Returns an array of DbUser objects
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

//    public function findOneBySomeField($value): ?DbUser
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
