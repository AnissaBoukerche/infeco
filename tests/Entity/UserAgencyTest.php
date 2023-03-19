<?php

namespace App\Tests\Entity;

use App\Entity\UserAgency;
use PHPUnit\Framework\TestCase;

class UserAgencyTest extends TestCase
{
    const USER_AGENCY_NAME = 'immo-marseille';
    const USER_AGENCY_EMAIL = 'immo-marseille@studi.fr';
    
public function testIsTrue() {

    $userAgency = new UserAgency();

    $userAgency->setName(self::USER_AGENCY_NAME)
        ->setAddress('10 avenue de Marseille')
        ->setZipCode('13000')
        ->setCity('Marseille')
        ->setEmail(self::USER_AGENCY_EMAIL)
        ->setPhone('0442505963')
        ->setPassword('123456')
        ->setAgencyFees('8');
    $this->assertTrue($userAgency->getName() === self::USER_AGENCY_NAME);
    $this->assertTrue($userAgency->getAddress() === '10 avenue de Marseille');
    $this->assertTrue($userAgency->getZipCode() === '13000');
    $this->assertTrue($userAgency->getCity() === self::USER_AGENCY_EMAIL);
    $this->assertTrue($userAgency->getPhone() === '0442505963');
    $this->assertTrue($userAgency->getPassword() === '123456');
    $this->assertTrue($userAgency->getAgencyFees() === '8');
}

public function testIsFalse() {

    $userAgency = new UserAgency();

    $userAgency->setName(self::USER_AGENCY_NAME)
        ->setAddress('10 avenue de Marseille')
        ->setZipCode('13000')
        ->setCity('Marseille')
        ->setEmail(self::USER_AGENCY_EMAIL)
        ->setPhone('0442505963')
        ->setPassword('123456')
        ->setAgencyFees('8');
    $this->assertFalse($userAgency->getName() === 'false');
    $this->assertFalse($userAgency->getAddress() === 'false');
    $this->assertFalse($userAgency->getZipCode() === 'false');
    $this->assertFalse($userAgency->getCity() === 'false@studi.fr');
    $this->assertFalse($userAgency->getPhone() === 'false');
    $this->assertFalse($userAgency->getPassword() === 'false');
    $this->assertFalse($userAgency->getAgencyFees() === '4');
}

public function testIsEmpty() {

    $userAgency = new UserAgency();

    $this->assertEmpty($userAgency->getId());
    $this->assertEmpty($userAgency->getName());
    $this->assertEmpty($userAgency->getAddress());
    $this->assertEmpty($userAgency->getZipCode());
    $this->assertEmpty($userAgency->getCity());
    $this->assertEmpty($userAgency->getPhone());
    $this->assertEmpty($userAgency->getPassword());
    $this->assertEmpty($userAgency->getAgencyFees());
}
}