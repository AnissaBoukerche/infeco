<?php

namespace App\DataFixtures;

use App\Entity\UserAgency;
use App\Tests\Unit\UserAgencyTest as UnitUserAgencyTest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserAgencyFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        // parent::__construct();
        $this->passwordHasher = $passwordHasher;
    }

    const USER_AGENCY_PASSWORD = '123456';
    const USER_AGENCY_REFERENCE = 'UserAgency';
    public function load(ObjectManager $manager): void
    {
        $userAgency = new UserAgency();

        $userAgency->setName(UnitUserAgencyTest::USER_AGENCY_NAME)
        ->setAddress('10 avenue de Marseille')
        ->setZipCode('13000')
        ->setCity('Marseille')
        ->setEmail(UnitUserAgencyTest::USER_AGENCY_EMAIL)
        ->setPhone('0442505963')
        ->setPassword(
        $this->passwordHasher->hashPassword($userAgency,self::USER_AGENCY_PASSWORD)
        )
        ->setAgencyFees(8);

        $userAgency = new UserAgency();

        $userAgency->setName('immo-marseille2')
        ->setAddress('10 avenue de Marseille')
        ->setZipCode('13000')
        ->setCity('Marseille')
        ->setEmail('immo-marseille2@studi.fr')
        ->setPhone('0442505963')
        ->setPassword(
        $this->passwordHasher->hashPassword($userAgency,self::USER_AGENCY_PASSWORD)
        )
        ->setAgencyFees(8);
        $manager->persist($userAgency);

        $manager->flush();
    }
}
