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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $exitAt = null;

    #[ORM\Column]
    private ?float $charges = null;

    #[ORM\Column]
    private ?float $rent = null;

    #[ORM\Column(nullable: false)]
    private ?float $balance = null;

    #[ORM\ManyToOne(inversedBy: 'rentals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Apartment $apartment = null;

    #[ORM\OneToMany(mappedBy: 'rental', targetEntity: InventoryOfFixtures::class)]
    private Collection $inventoryOfFixtures;

    #[ORM\ManyToMany(targetEntity: Tenant::class, mappedBy: 'rental')]
    private Collection $tenants;

    #[ORM\OneToMany(mappedBy: 'rental', targetEntity: Payment::class)]
    private Collection $payments;

    public function __construct()
    {
        $this->inventoryOfFixtures = new ArrayCollection();
        $this->tenants = new ArrayCollection();
        $this->payments = new ArrayCollection();
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

    public function calculateDeposit():?float
    {
        return $this->getRent();
    }
    public function calculateDurationInMonths(): int
{
    $entryAt = $this->getEntryAt();
    $currentDate = new \DateTime();
    $date = ($currentDate<$this->getExitAt())? $currentDate : $this->getExitAt();
    $result = $entryAt->diff($date)->m + ($entryAt->diff($date)->y * 12);
    return ($result <= 0)? 1 : $result;
}

public function calculateTotalDurationInMonths(): int
{
    $entryAt = $this->getEntryAt();
    $exitAt = $this->getExitAt();
    $result = $entryAt->diff($exitAt)->m + ($entryAt->diff($exitAt)->y * 12);
    return ($result <= 0)? 1 : $result;
}

public function calculateAgencyFeesOnRent(): float {
    $agencyPercentage = $this->getUserAgency()->getAgencyFees()/100;
    $agencyFeesOnRent = $this->getRent() * $agencyPercentage;
    return $agencyFeesOnRent;
}
public function calculateTotalAmount(): float
{
    $rent = $this->getRent();
    $charges = $this->getCharges();
    $deposit = $this->calculateDeposit();
    $agencyFees = $this->calculateAgencyFeesOnRent();
    $durationInMonths = $this->calculateDurationInMonths();

    return ($rent + $charges + $agencyFees) * $durationInMonths + $deposit;
}

public function calculateTotalAmountAtExit(): float
{
    $rent = $this->getRent();
    $charges = $this->getCharges();
    $deposit = $this->calculateDeposit();
    $agencyFees = $this->calculateAgencyFeesOnRent();
    $totalDurationInMonths = $this->calculateTotalDurationInMonths();

    return ($rent + $charges + $agencyFees) * $totalDurationInMonths + $deposit;
}
public function calculateRentBalance(): float
{
    $totalAmount = $this->calculateTotalAmount();
    $payments = $this->getPayments();
    $totalPayments = 0;

    foreach ($payments as $payment) {
            $totalPayments += $payment->getAmount();
    }
    $rentBalance = $totalPayments - $totalAmount;

    return $rentBalance;
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

    /**
     * @return Collection<int, Tenant>
     */
    public function getTenants(): Collection
    {
        return $this->tenants;
    }

    public function addTenant(Tenant $tenant): self
    {
        if (!$this->tenants->contains($tenant)) {
            $this->tenants->add($tenant);
            $tenant->addRental($this);
        }

        return $this;
    }

    public function removeTenant(Tenant $tenant): self
    {
        if ($this->tenants->removeElement($tenant)) {
            $tenant->removeRental($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setRental($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getRental() === $this) {
                $payment->setRental(null);
            }
        }

        return $this;
    }

}