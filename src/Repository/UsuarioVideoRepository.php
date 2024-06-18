<?php

namespace App\Repository;

use App\Entity\UsuarioVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsuarioVideo>
 *
 * @method UsuarioVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsuarioVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsuarioVideo[]    findAll()
 * @method UsuarioVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuarioVideo::class);
    }

//    /**
//     * @return UsuarioVideo[] Returns an array of UsuarioVideo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UsuarioVideo
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
