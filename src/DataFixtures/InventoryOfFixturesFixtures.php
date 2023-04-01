<?php

namespace App\DataFixtures;

use App\Entity\InventoryOfFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InventoryOfFixturesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $inventoryOfFixtures = new InventoryOfFixtures();
        $createdAt = new \DateTimeImmutable();
        $rental = $this->getReference(RentalFixtures::RENTAL_REFERENCE);

        $inventoryOfFixtures->setCreatedAt($createdAt)
        ->setStatus(true)
        ->setComments('Très bon état')
        ->setRental($rental);
        $manager->persist($inventoryOfFixtures);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RentalFixtures::class,
        ];
    }
}
