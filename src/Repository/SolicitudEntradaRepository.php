<?php

namespace App\Repository;

use App\Entity\SolicitudEntrada;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SolicitudEntrada|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolicitudEntrada|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolicitudEntrada[]    findAll()
 * @method SolicitudEntrada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolicitudEntradaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolicitudEntrada::class);
    }

    // /**
    //  * @return SolicitudEntrada[] Returns an array of SolicitudEntrada objects
    //  */
    /*
    public function findByExampleField($value)
    {
    return $this->createQueryBuilder('s')
    ->andWhere('s.exampleField = :val')
    ->setParameter('val', $value)
    ->orderBy('s.id', 'ASC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult()
    ;
    }
     */

    /*
public function findOneBySomeField($value): ?SolicitudEntrada
{
return $this->createQueryBuilder('s')
->andWhere('s.exampleField = :val')
->setParameter('val', $value)
->getQuery()
->getOneOrNullResult()
;
}
 */
}
