<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    const PAYMENT_REFERENCE = 'Payment';
    public function load(ObjectManager $manager): void
    {
        $payment = new Payment();
        $paymentAt = new DateTime();
        $rental = $this->getReference(RentalFixtures::RENTAL_REFERENCE);

        $payment->setPaymentAt($paymentAt)
        ->setAmount(550.1)
        ->setType('APL')
        ->setPaymentMethod('Virement')
        ->setRental($rental);
        $this->addReference(self::PAYMENT_REFERENCE, $payment);
        $manager->persist($payment);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            RentalFixtures::class,
        ];
    }
}
