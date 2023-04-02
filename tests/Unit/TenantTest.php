<?php

namespace App\Tests\Unit;

use App\Entity\Tenant;
use DateTime;
use PHPUnit\Framework\TestCase;

class TenantTest extends TestCase
{
    public function testIsTrue()
    {
        $tenant = new Tenant;
        $dateOfBirth = new DateTime();

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
        ->setGuarantor('Jean Monde');
        $this->assertTrue($tenant->getLastName() === 'Monde');
        $this->assertTrue($tenant->getFirstName() === 'James');
        $this->assertTrue($tenant->getCivilStatus()=== 'Married');
        $this->assertTrue($tenant->getDateOfBirth()=== $dateOfBirth);
        $this->assertTrue($tenant->getBirthPlace() === 'Marseille');
        $this->assertTrue($tenant->getEmail() === 'jamesmonde@studi.fr');
        $this->assertTrue($tenant->getPhone() === '0601020304');
        $this->assertTrue($tenant->getAddress() === '20 Chemin des Guarrigues');
        $this->assertTrue($tenant->getCity()=== 'Marseille');
        $this->assertTrue($tenant->getZipCode()=== '13000');
        $this->assertTrue($tenant->getGuarantor()=== 'Jean Monde');
    }


public function testIsFalse()
{
    $tenant = new Tenant;
    $dateOfBirth = new DateTime();

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
    ->setGuarantor('Jean Monde');
    $this->assertFalse($tenant->getLastName() === 'Bond');
    $this->assertFalse($tenant->getFirstName() === 'Jean');
    $this->assertFalse($tenant->getCivilStatus()=== 'Single');
    $this->assertFalse($tenant->getDateOfBirth()=== new DateTime());
    $this->assertFalse($tenant->getBirthPlace() === 'Aix-en-Provence');
    $this->assertFalse($tenant->getEmail() === 'jeanbond@studi.fr');
    $this->assertFalse($tenant->getPhone() === '0601020305');
    $this->assertFalse($tenant->getAddress() === '25 Chemin des Guarrigues');
    $this->assertFalse($tenant->getCity()=== 'Aix-en-Provence');
    $this->assertFalse($tenant->getZipCode()=== '13090');
    $this->assertFalse($tenant->getGuarantor()=== 'James Bond');
}

public function testIsEmpty()
{
    $tenant = new Tenant;

    $this->assertEmpty($tenant->getLastName());
    $this->assertEmpty($tenant->getFirstName());
    $this->assertEmpty($tenant->getCivilStatus());
    $this->assertEmpty($tenant->getBirthPlace());
    $this->assertEmpty($tenant->getEmail());
    $this->assertEmpty($tenant->getPhone());
    $this->assertEmpty($tenant->getAddress());
    $this->assertEmpty($tenant->getCity());
    $this->assertEmpty($tenant->getZipCode());
    $this->assertEmpty($tenant->getGuarantor());
}
}
