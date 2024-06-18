<?php

namespace App\Repository;

use App\Entity\ComentarioCancion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComentarioCancion>
 *
 * @method ComentarioCancion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComentarioCancion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComentarioCancion[]    findAll()
 * @method ComentarioCancion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComentarioCancionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComentarioCancion::class);
    }

//    /**
//     * @return ComentarioCancion[] Returns an array of ComentarioCancion objects
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

//    public function findOneBySomeField($value): ?ComentarioCancion
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
