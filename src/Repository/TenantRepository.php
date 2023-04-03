<?php

namespace App\Repository;

use App\Entity\Rental;
use App\Entity\Tenant;
use App\Entity\UserAgency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tenant>
 *
 * @method Tenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tenant[]    findAll()
 * @method Tenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tenant::class);
    }

    public function save(Tenant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tenant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByUserAgency(UserAgency $userAgency)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.rental', 'rental')
            ->innerJoin('rental.apartment', 'apartment')
            ->where('apartment.userAgency = :userAgency')
            ->setParameter('userAgency', $userAgency)
            ->getQuery()
            ->getResult();
    }

    public function findByRental(Rental $rental)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.rental', 'rental')
            ->where('rental.id = :rental')
            ->setParameter('rental', $rental->getId())
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Tenant[] Returns an array of Tenant objects
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

//    public function findOneBySomeField($value): ?Tenant
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
