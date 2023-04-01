<?php

namespace App\Repository;

use App\Entity\InventoryOfFixtures;
use App\Entity\UserAgency;
use App\Entity\Rental;
use App\Entity\Apartment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InventoryOfFixtures>
 *
 * @method InventoryOfFixtures|null find($id, $lockMode = null, $lockVersion = null)
 * @method InventoryOfFixtures|null findOneBy(array $criteria, array $orderBy = null)
 * @method InventoryOfFixtures[]    findAll()
 * @method InventoryOfFixtures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryOfFixturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InventoryOfFixtures::class);
    }

    public function save(InventoryOfFixtures $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InventoryOfFixtures $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByUserAgency(UserAgency $userAgency)
    {
        return $this->createQueryBuilder('i')
            ->innerJoin('i.rental', 'rental')
            ->innerJoin('rental.apartment', 'apartment')
            ->where('apartment.userAgency = :userAgency')
            ->setParameter('userAgency', $userAgency)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return InventoryOfFixtures[] Returns an array of InventoryOfFixtures objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InventoryOfFixtures
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
