<?php

namespace App\DataFixtures;

use App\Entity\Rental;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
<<<<<<< Updated upstream
use Doctrine\Persistence\ObjectManager;

class RentalFixtures extends Fixture
{
=======
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class RentalFixtures extends Fixture implements DependentFixtureInterface
{
    const RENTAL_REFERENCE = 'Rental';
>>>>>>> Stashed changes
    public function load(ObjectManager $manager): void
    {
        $rental = new Rental();
        $entryAt = new DateTime();
        $exitAt = new DateTime();
<<<<<<< Updated upstream
=======
        $apartment = $this->getReference(ApartmentFixtures::APARTMENT_REFERENCE);
>>>>>>> Stashed changes

        $rental->setEntryAt($entryAt)
        ->setExitAt($exitAt)
        ->setCharges(150.50)
        ->setRent(456.75)
<<<<<<< Updated upstream
        ->setBalance(340.25);
=======
        ->setBalance(340.25)
        ->setApartment($apartment);
        $this->addReference(self::RENTAL_REFERENCE, $rental);
>>>>>>> Stashed changes
        $manager->persist($rental);

        $manager->flush();
    }
<<<<<<< Updated upstream
=======

    public function getDependencies()
    {
        return [
            ApartmentFixtures::class,
        ];
    }
>>>>>>> Stashed changes
}
