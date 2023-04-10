<?php

namespace App\RentalReceipts;

use App\DataFixtures\PaymentFixtures;
use App\Entity\Payment;
use App\Entity\RentalReceipts;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RentalReceiptsFixtures extends Fixture implements DependentFixtureInterface
{
    const RENTAL_RECEIPTS_REFERENCE = 'RentalReceipts';
    public function load(ObjectManager $manager): void
    {
        $rentalReceipts = new RentalReceipts();
        $startAt= new \DateTime();
        $endAt= new \DateTime();
        $payment = $this->getReference(PaymentFixtures::PAYMENT_REFERENCE);
        
        $rentalReceipts->setStartAt($startAt)
        ->setEndAt($endAt)
        ->setRentAmount(850.5)
        ->setChargesAmount(150.5)
        ->setAgencyFeesAmount(85.05)
        ->setTotalAmount(1686.5)
        ->setBalance(0)
        ->addPayment($payment);
        $this->addReference(self::RENTAL_RECEIPTS_REFERENCE, $rentalReceipts);
        $manager->persist($rentalReceipts);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            PaymentFixtures::class,
        ];
    }
}
