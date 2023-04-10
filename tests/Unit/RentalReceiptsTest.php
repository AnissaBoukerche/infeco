<?php

namespace App\Tests\Unit;

use App\Entity\RentalReceipts;
use DateTime;
use PHPUnit\Framework\TestCase;


class RentalReceiptsTest extends TestCase
{
    public function testIsTrue()
    {
        $rentalReceipts = new RentalReceipts();
        $startAt = new DateTime();
        $endAt = new DateTime();

        $rentalReceipts->setStartAt($startAt)
        ->setEndAt($endAt)
        ->setRentAmount(850.5)
        ->setChargesAmount(150.5)
        ->setAgencyFeesAmount(85.05)
        ->setTotalAmount(1686.5)
        ->setBalance(10.5);
        $this->assertTrue($rentalReceipts->getStartAt() === $startAt);
        $this->assertTrue($rentalReceipts->getEndAt() === $endAt);
        $this->assertTrue($rentalReceipts->getRentAmount()=== 850.5);
        $this->assertTrue($rentalReceipts->getChargesAmount()=== 150.5);
        $this->assertTrue($rentalReceipts->getAgencyFeesAmount()=== 85.05);
        $this->assertTrue($rentalReceipts->getTotalAmount()=== 1686.5);
        $this->assertTrue($rentalReceipts->getBalance()=== 10.5);
        
    }
    public function testIsFalse()
    {
        $rentalReceipts = new RentalReceipts();
        $startAt = new DateTime();
        $endAt = new DateTime();

        $rentalReceipts->setStartAt($startAt)
        ->setEndAt($endAt)
        ->setRentAmount(850.5)
        ->setChargesAmount(150.5)
        ->setAgencyFeesAmount(85.05)
        ->setTotalAmount(1686.5)
        ->setBalance(0);
        $this->assertFalse($rentalReceipts->getStartAt() === new DateTime());
        $this->assertFalse($rentalReceipts->getEndAt() === new DateTime());
        $this->assertFalse($rentalReceipts->getRentAmount()=== 150.50);
        $this->assertFalse($rentalReceipts->getChargesAmount()=== 456.75);
        $this->assertFalse($rentalReceipts->getAgencyFeesAmount()=== 340.25);
        $this->assertFalse($rentalReceipts->getTotalAmount()=== 340.25);
        $this->assertFalse($rentalReceipts->getBalance()=== 340.25);
        
    }
    public function testIsEmpty()
    {
        $rentalReceipts = new RentalReceipts();

        $this->assertEmpty($rentalReceipts->getStartAt());
        $this->assertEmpty($rentalReceipts->getEndAt());
        $this->assertEmpty($rentalReceipts->getRentAmount());
        $this->assertEmpty($rentalReceipts->getChargesAmount());
        $this->assertEmpty($rentalReceipts->getAgencyFeesAmount());
        $this->assertEmpty($rentalReceipts->getTotalAmount());
        $this->assertEmpty($rentalReceipts->getBalance());
    }
}

