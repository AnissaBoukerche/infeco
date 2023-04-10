<?php

namespace App\Repository;

use App\Entity\Rental;
use App\Entity\RentalReceipts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RentalReceipts>
 *
 * @method RentalReceipts|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentalReceipts|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentalReceipts[]    findAll()
 * @method RentalReceipts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentalReceiptsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentalReceipts::class);
    }

    public function save(RentalReceipts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RentalReceipts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByRental(Rental $rental)
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.payment', 'payment')
            ->where('payment.rental = :rental')
            ->setParameter('rental', $rental->getId())
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return RentalReceipts[] Returns an array of RentalReceipts objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RentalReceipts
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
