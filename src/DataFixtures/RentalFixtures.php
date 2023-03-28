<?php

namespace App\DataFixtures;

use App\Entity\Rental;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RentalFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rental = new Rental();
        $entryAt = new DateTime();
        $exitAt = new DateTime();

        $rental->setEntryAt($entryAt)
        ->setExitAt($exitAt)
        ->setCharges(150.50)
        ->setRent(456.75)
        ->setBalance(340.25);
        $manager->persist($rental);

        $manager->flush();
    }
}
