<?php

namespace App\DataFixtures;

use App\Entity\Rental;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RentalFixtures extends Fixture implements DependentFixtureInterface
{
    const RENTAL_REFERENCE = 'Rental';

    public function load(ObjectManager $manager): void
    {
        $rental = new Rental();
        $entryAt = new DateTime();
        $exitAt = new DateTime();
        $apartment = $this->getReference(ApartmentFixtures::APARTMENT_REFERENCE);

        $rental->setEntryAt($entryAt)
        ->setExitAt($exitAt)
        ->setCharges(150.50)
        ->setRent(456.75)
        ->setBalance(56.75)
        ->setApartment($apartment);
        $this->addReference(self::RENTAL_REFERENCE, $rental);

        $manager->persist($rental);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ApartmentFixtures::class,
        ];
    }
}
