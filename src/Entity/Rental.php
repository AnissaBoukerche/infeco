<?php

namespace App\Entity;

use App\Repository\RentalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentalRepository::class)]
class Rental
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $entryAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $exitAt = null;

    #[ORM\Column]
    private ?float $charges = null;

    #[ORM\Column]
    private ?float $rent = null;

    #[ORM\Column]
    private ?float $balance = null;

    #[ORM\ManyToOne(inversedBy: 'rentals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Apartment $apartment = null;

    #[ORM\OneToMany(mappedBy: 'rental', targetEntity: InventoryOfFixtures::class)]
    private Collection $inventoryOfFixtures;

    public function __construct()
    {
        $this->inventoryOfFixtures = new ArrayCollection();
    }

    public function getUserAgency(){
        if($this->getApartment() === null){
            return null;
        }
        return $this->getApartment()->getUserAgency();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntryAt(): ?\DateTimeInterface
    {
        return $this->entryAt;
    }

    public function setEntryAt(\DateTimeInterface $entryAt): self
    {
        $this->entryAt = $entryAt;

        return $this;
    }

    public function getExitAt(): ?\DateTimeInterface
    {
        return $this->exitAt;
    }

    public function setExitAt(?\DateTimeInterface $exitAt): self
    {
        $this->exitAt = $exitAt;

        return $this;
    }

    public function getCharges(): ?float
    {
        return $this->charges;
    }

    public function setCharges(float $charges): self
    {
        $this->charges = $charges;

        return $this;
    }

    public function getRent(): ?float
    {
        return $this->rent;
    }

    public function setRent(float $rent): self
    {
        $this->rent = $rent;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getApartment(): ?Apartment
    {
        return $this->apartment;
    }

    public function setApartment(?Apartment $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }

    /**
     * @return Collection<int, InventoryOfFixtures>
     */
    public function getInventoryOfFixtures(): Collection
    {
        return $this->inventoryOfFixtures;
    }

    public function addInventoryOfFixture(InventoryOfFixtures $inventoryOfFixture): self
    {
        if (!$this->inventoryOfFixtures->contains($inventoryOfFixture)) {
            $this->inventoryOfFixtures->add($inventoryOfFixture);
            $inventoryOfFixture->setRental($this);
        }

        return $this;
    }

    public function removeInventoryOfFixture(InventoryOfFixtures $inventoryOfFixture): self
    {
        if ($this->inventoryOfFixtures->removeElement($inventoryOfFixture)) {
            // set the owning side to null (unless already changed)
            if ($inventoryOfFixture->getRental() === $this) {
                $inventoryOfFixture->setRental(null);
            }
        }

        return $this;
    }
}
