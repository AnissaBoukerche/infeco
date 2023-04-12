<?php

namespace App\Entity;

use App\Repository\UserAgencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Validator\Constraints as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserAgencyRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class UserAgency implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email]
    #[CustomAssert\EmailDomain(['studi.fr'])]
    private ?string $email = null;

    #[ORM\Column(type:'json')]
    #[Assert\NotNull()]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?int $agencyFees = null;

    #[ORM\Column(length: 255)]
    private ?string $zipCode = null;

    #[ORM\OneToMany(mappedBy: 'userAgency', targetEntity: Apartment::class)]
    private Collection $apartment;

    public function __construct()
    {
        $this->apartment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAgencyFees(): ?int
    {
        return $this->agencyFees;
    }

    public function setAgencyFees(int $agencyFees): self
    {
        $this->agencyFees = $agencyFees;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return Collection<int, Apartment>
     */
    public function getApartment(): Collection
    {
        return $this->apartment;
    }

    public function addApartment(Apartment $apartment): self
    {
        if (!$this->apartment->contains($apartment)) {
            $this->apartment->add($apartment);
            $apartment->setUserAgency($this);
        }

        return $this;
    }

    public function removeApartment(Apartment $apartment): self
    {
        if ($this->apartment->removeElement($apartment)) {
            // set the owning side to null (unless already changed)
            if ($apartment->getUserAgency() === $this) {
                $apartment->setUserAgency(null);
            }
        }

        return $this;
    }
}
