<?php

namespace App\Repository;

use App\Entity\Especialidade;
use App\Entity\Medico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Especialidade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Especialidade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Especialidade[]    findAll()
 * @method Especialidade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Medico::class);
    }

    // /**
    //  * @return Especialidade[] Returns an array of Especialidade objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Especialidade
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}