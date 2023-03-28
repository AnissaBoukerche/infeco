<?php

namespace App\Tests\Unit;

use App\Entity\Apartment;
use PHPUnit\Framework\TestCase;

class ApartmentTest extends TestCase
{
    public function testIsTrue()
    {
        $apartment = new Apartment;

        $apartment->setAddress('10 rue de la Rose')
        ->setAdditionalAddressDetails('Appartment 2B')
        ->setCity('Marseille')
        ->setZipCode('13000');
        $this->assertTrue($apartment->getAddress() === '10 rue de la Rose');
        $this->assertTrue($apartment->getAdditionalAddressDetails() === 'Appartment 2B');
        $this->assertTrue($apartment->getCity()=== 'Marseille');
        $this->assertTrue($apartment->getZipCode()=== '13000');
    }


public function testIsFalse()
{
    $apartment = new Apartment;

    $apartment->setAddress('10 rue de la Rose')
    ->setAdditionalAddressDetails('Appartment 2B')
    ->setCity('Marseille')
    ->setZipCode('13000');
    $this->assertFalse($apartment->getAddress() === 'false');
    $this->assertFalse($apartment->getAdditionalAddressDetails() === 'false');
    $this->assertFalse($apartment->getCity()=== 'false');
    $this->assertFalse($apartment->getZipCode()=== 'false');
}

public function testIsEmpty()
{
    $apartment = new Apartment;

    $this->assertEmpty($apartment->getAddress());
    $this->assertEmpty($apartment->getAdditionalAddressDetails());
    $this->assertEmpty($apartment->getCity());
    $this->assertEmpty($apartment->getZipCode());
}
}
