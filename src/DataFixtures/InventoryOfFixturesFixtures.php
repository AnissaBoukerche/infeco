<?php

namespace App\DataFixtures;

use App\Entity\InventoryOfFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InventoryOfFixturesFixtures extends Fixture implements DependentFixtureInterface
{
    const INVENTORY_OF_FIXTURES_REFERENCE = 'inventory_of_fixtures';
    public function load(ObjectManager $manager): void
    {
        $inventoryOfFixtures = new InventoryOfFixtures();
        $createdAt = new \DateTimeImmutable();
        $rental = $this->getReference(RentalFixtures::RENTAL_REFERENCE);

        $inventoryOfFixtures->setCreatedAt($createdAt)
        ->setStatus(true)
        ->setComments('Très bon état')
        ->setRental($rental);
        $this->addReference(self::INVENTORY_OF_FIXTURES_REFERENCE, $inventoryOfFixtures);
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
