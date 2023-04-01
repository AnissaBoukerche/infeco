<?php

namespace App\Tests\Unit;

use App\Entity\InventoryOfFixtures;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class InventoryOfFixturesTest extends TestCase
{
    public function testIsTrue() {

    $inventoryOfFixtures = new InventoryOfFixtures();
    $createdAt = new DateTimeImmutable();

    $inventoryOfFixtures->setCreatedAt($createdAt)
        ->setStatus(true)
        ->setComments('Très bon état');
    $this->assertTrue($inventoryOfFixtures->getCreatedAt() === $createdAt);
    $this->assertTrue($inventoryOfFixtures->isStatus() === true);
    $this->assertTrue($inventoryOfFixtures->getComments() === 'Très bon état');
}
public function testIsFalse() {

    $inventoryOfFixtures = new InventoryOfFixtures();
    $createdAt = new DateTimeImmutable();

    $inventoryOfFixtures->setCreatedAt($createdAt)
        ->setStatus(1)
        ->setComments('Très bon état');
    $this->assertFalse($inventoryOfFixtures->getCreatedAt() === new DateTimeImmutable());
    $this->assertFalse($inventoryOfFixtures->isStatus() === 0);
    $this->assertFalse($inventoryOfFixtures->getComments() === 'Mauvais état');
}
public function testIsEmpty() {

    $inventoryOfFixtures = new InventoryOfFixtures();

    $this->assertEmpty($inventoryOfFixtures->getComments());
}
}