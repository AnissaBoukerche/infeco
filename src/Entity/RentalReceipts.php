<?php

namespace App\Entity;

use App\Repository\RentalReceiptsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentalReceiptsRepository::class)]
class RentalReceipts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?float $rentAmount = null;

    #[ORM\Column]
    private ?float $chargesAmount = null;

    #[ORM\Column]
    private ?float $agencyFeesAmount = null;

    #[ORM\Column]
    private ?float $totalAmount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startAt = null;

    #[ORM\Column (type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column]
    private ?float $balance = null;

    #[ORM\OneToMany(mappedBy: 'rentalReceipts', targetEntity: Payment::class)]
    private Collection $payment;

    public function __construct()
    {
        $this->payment = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function calculateDurationInMonths(): int
{
    $startAt = $this->getStartAt();
    $endAt = $this->getEndAt();
    $result = $startAt->diff($endAt)->m + ($startAt->diff($endAt)->y * 12);
    return ($result <= 0)? 1 : $result;
}

public function calculateAgencyFeesOnRent(): float {
    $agencyPercentage = $this->getRental()->getUserAgency()->getAgencyFees()/100;
    $agencyFeesOnRent = $this->getRental()->getRent() * $agencyPercentage;
    return $agencyFeesOnRent;
}

public function calculateTotalAmount(): float
{
    $rent = $this->getRental()->getRent();
    $charges = $this->getRental()->getCharges();
    $agencyFees = $this->calculateAgencyFeesOnRent();
    $durationInMonths = $this->calculateDurationInMonths();

    return ($rent + $charges + $agencyFees) * $durationInMonths;
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
    
    public function getRental(){
        if(!isset($this->getPayments()[0])){
            return null;
        }
        return $this->getPayments()[0]->getRental();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRentAmount(): ?float
    {
        return $this->rentAmount;
    }

    public function setRentAmount(float $rentAmount): self
    {
        $this->rentAmount = $rentAmount;

        return $this;
    }

    public function getChargesAmount(): ?float
    {
        return $this->chargesAmount;
    }

    public function setChargesAmount(float $chargesAmount): self
    {
        $this->chargesAmount = $chargesAmount;

        return $this;
    }

    public function getAgencyFeesAmount(): ?float
    {
        return $this->agencyFeesAmount;
    }

    public function setAgencyFeesAmount(float $agencyFeesAmount): self
    {
        $this->agencyFeesAmount = $agencyFeesAmount;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

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

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payment;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payment->contains($payment)) {
            $this->payment->add($payment);
            $payment->setRentalReceipts($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payment->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getRentalReceipts() === $this) {
                $payment->setRentalReceipts(null);
            }
        }

        return $this;
    }

}
