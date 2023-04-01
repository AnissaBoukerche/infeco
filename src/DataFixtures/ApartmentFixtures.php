<?php

namespace App\DataFixtures;

use App\Entity\Apartment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ApartmentFixtures extends Fixture implements DependentFixtureInterface
{
    const APARTMENT_REFERENCE = 'Apartment';
    public function load(ObjectManager $manager): void
    {
        $apartment = new Apartment;
        $userAgency = $this->getReference(UserAgencyFixtures::USER_AGENCY_REFERENCE);


        $apartment->setAddress('10 rue de la Rose')
        ->setAdditionalAddressDetails('Appartment 2B')
        ->setCity('Marseille')
        ->setZipCode('13000')
        ->setUserAgency($userAgency);
        $this->addReference(self::APARTMENT_REFERENCE, $apartment);
        $manager->persist($apartment);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserAgencyFixtures::class,
        ];
    }
}