<?php

namespace App\Repository;

use App\Entity\ComentarioProducto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComentarioProducto>
 *
 * @method ComentarioProducto|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComentarioProducto|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComentarioProducto[]    findAll()
 * @method ComentarioProducto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComentarioProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComentarioProducto::class);
    }

//    /**
//     * @return ComentarioProducto[] Returns an array of ComentarioProducto objects
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

//    public function findOneBySomeField($value): ?ComentarioProducto
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
