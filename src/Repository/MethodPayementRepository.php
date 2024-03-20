<?php

namespace App\Repository;

use App\Entity\MethodPayement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MethodPayement>
 *
 * @method MethodPayement|null find($id, $lockMode = null, $lockVersion = null)
 * @method MethodPayement|null findOneBy(array $criteria, array $orderBy = null)
 * @method MethodPayement[]    findAll()
 * @method MethodPayement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MethodPayementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MethodPayement::class);
    }

    //    /**
    //     * @return MethodPayement[] Returns an array of MethodPayement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MethodPayement
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
