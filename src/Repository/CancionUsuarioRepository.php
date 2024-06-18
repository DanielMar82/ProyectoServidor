<?php

namespace App\Repository;

use App\Entity\CancionUsuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CancionUsuario>
 *
 * @method CancionUsuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method CancionUsuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method CancionUsuario[]    findAll()
 * @method CancionUsuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CancionUsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CancionUsuario::class);
    }

//    /**
//     * @return CancionUsuario[] Returns an array of CancionUsuario objects
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

//    public function findOneBySomeField($value): ?CancionUsuario
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
