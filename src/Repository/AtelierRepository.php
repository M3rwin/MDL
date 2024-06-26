<?php

namespace App\Repository;

use App\Entity\Atelier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Atelier>
 *
 * @method Atelier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Atelier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Atelier[]    findAll()
 * @method Atelier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtelierRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Atelier::class);
    }

    public function findAll(): array {
        return $this->createQueryBuilder('a')
                        ->orderBy('a.id', 'ASC')
                        ->getQuery()
                        ->getResult()
        ;
    }

    public function findNotFull(): array {
        return $this->createQueryBuilder('a')
                        ->leftJoin('a.inscriptions', 'i')
                        ->groupBy('a.id')
                        ->having('COUNT(i) < a.nbplacesmaxi') // Assurez-vous que 'i' et 'a.nbplacesmaxi' correspondent à vos mappings
                        ->orderBy('a.id', 'ASC')
                        ->getQuery()
                        ->getResult()
        ;
    }

//    /**
//     * @return Atelier[] Returns an array of Atelier objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
//    public function findOneBySomeField($value): ?Atelier
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
