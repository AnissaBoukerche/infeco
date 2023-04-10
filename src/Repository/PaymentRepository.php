<?php

namespace App\Repository;

use App\Entity\Payment;
use App\Entity\Rental;
use App\Entity\UserAgency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Payment>
 *
 * @method Payment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payment[]    findAll()
 * @method Payment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    public function save(Payment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Payment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByUserAgency(UserAgency $userAgency)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.rental', 'rental')
            ->innerJoin('rental.apartment', 'apartment')
            ->where('apartment.userAgency = :userAgency')
            ->setParameter('userAgency', $userAgency)
            ->getQuery()
            ->getResult();
    }

    public function findByRental(Rental $rental)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.rental', 'rental')
            ->where('rental.id = :rental')
            ->setParameter('rental', $rental->getId())
            ->getQuery()
            ->getResult();
    }

    public function findPaymentsBetweenDates(Rental $rental, \DateTimeInterface $startAt, \DateTimeInterface $endAt): array
    {
        //Calculate number of months between dates
        $diffMonths = $startAt->diff($endAt)->m + ($startAt->diff($endAt)->y * 12);
        // If the number of months is less than or equal to zero, set it to 1 to avoid division by zero errors later
        if ($diffMonths <= 0) {
            $diffMonths = 1;
            }
        // Query the database to get the total amount of payments made between the two dates for the given rental
        return $this->createQueryBuilder('p')
            //link the payment to the rental
            ->innerJoin('p.rental', 'rental')
            ->where('rental = :rental')
            ->setParameter('rental', $rental)
            ->andWhere('p.paymentAt >= :startAt')
            ->andWhere('p.paymentAt <= :endAt')
            ->setParameter('startAt', $startAt->format('Y-m-d'))
            ->setParameter('endAt', $endAt->format('Y-m-d'))
            ->getQuery()
            ->getResult();
        
    }

    public function findPaymentsWithoutRentalReceipts()
    {
        return $this->createQueryBuilder('p')
            ->where('p.rentalReceipts is null')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Payment[] Returns an array of Payment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Payment
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
