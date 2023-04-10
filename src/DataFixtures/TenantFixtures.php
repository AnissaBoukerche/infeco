<?php

namespace App\DataFixtures;

use App\Entity\Tenant;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TenantFixtures extends Fixture implements DependentFixtureInterface
{
    const TENANT_REFERENCE = 'Tenant';
    public function load(ObjectManager $manager): void
    {
        $tenant = new Tenant;
        $dateOfBirth = new DateTime();
        $rental = $this->getReference(RentalFixtures::RENTAL_REFERENCE);

        $tenant->setLastName('Monde')
        ->setFirstName('James')
        ->setCivilStatus('Married')
        ->setDateOfBirth($dateOfBirth)
        ->setBirthPlace('Marseille')
        ->setEmail('jamesmonde@studi.fr')
        ->setPhone('0601020304')
        ->setAddress('20 Chemin des Guarrigues')
        ->setCity('Marseille')
        ->setZipCode('13000')
        ->setGuarantor('Jean Monde')
        ->setUpdatedAt(new \DateTimeImmutable())
        ->addRental($rental);
        $this->addReference(self::TENANT_REFERENCE, $tenant);
        $manager->persist($tenant);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RentalFixtures::class,
        ];
    }
}
