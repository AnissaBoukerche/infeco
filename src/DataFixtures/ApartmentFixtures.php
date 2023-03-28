<?php

namespace App\DataFixtures;

use App\Entity\Apartment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ApartmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $apartment = new Apartment;

        $apartment->setAddress('10 rue de la Rose')
        ->setAdditionalAddressDetails('Appartment 2B')
        ->setCity('Marseille')
        ->setZipCode('13000');
        
        $manager->persist($apartment);

        $manager->flush();
    }
}
