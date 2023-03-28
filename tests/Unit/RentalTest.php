<?php

namespace App\Tests\Unit;

use App\Entity\Rental;
use DateTime;
use PHPUnit\Framework\TestCase;


class RentalTest extends TestCase
{
    public function testIsTrue()
    {
        $rental = new Rental();
        $entryAt = new DateTime();
        $exitAt = new DateTime();

        $rental->setEntryAt($entryAt)
        ->setExitAt($exitAt)
        ->setCharges(150.50)
        ->setRent(456.75)
        ->setBalance(340.25);
        $this->assertTrue($rental->getEntryAt() === $entryAt);
        $this->assertTrue($rental->getExitAt() === $exitAt);
        $this->assertTrue($rental->getCharges()=== 150.50);
        $this->assertTrue($rental->getRent()=== 456.75);
        $this->assertTrue($rental->getBalance()=== 340.25);
        
    }
    public function testIsFalse()
    {
        $rental = new Rental();
        $entryAt = new DateTime();
        $exitAt = new DateTime();

        $rental->setEntryAt($entryAt)
        ->setExitAt($exitAt)
        ->setCharges(150.50)
        ->setRent(456.75)
        ->setBalance(340.25);
        $this->assertFalse($rental->getEntryAt() === new DateTime());
        $this->assertFalse($rental->getExitAt() === new DateTime());
        $this->assertFalse($rental->getCharges()=== 151.50);
        $this->assertFalse($rental->getRent()=== 457.75);
        $this->assertFalse($rental->getBalance()=== 341.25);
        
    }
    public function testIsEmpty()
    {
        $rental = new Rental();

        $this->assertEmpty($rental->getEntryAt());
        $this->assertEmpty($rental->getExitAt());
        $this->assertEmpty($rental->getCharges());
        $this->assertEmpty($rental->getRent());
        $this->assertEmpty($rental->getBalance());
    }
}

