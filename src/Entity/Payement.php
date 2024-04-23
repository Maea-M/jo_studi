<?php

namespace App\Entity;

use App\Repository\PayementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayementRepository::class)]
class Payement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true, unique: true)]
    private ?string $secondKey = null;

    #[ORM\ManyToOne]
    private ?User $User = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?ordersDetails $ordersDetails = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsPaid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSecondKey(): ?string
    {
        return $this->secondKey;
    }

    public function setSecondKey(?string $secondKey): static
    {
        $this->secondKey = $secondKey;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getOrdersDetails(): ?ordersDetails
    {
        return $this->ordersDetails;
    }

    public function setOrdersDetails(?ordersDetails $ordersDetails): static
    {
        $this->ordersDetails = $ordersDetails;

        return $this;
    }

    public function isIsPaid(): ?bool
    {
        return $this->IsPaid;
    }

    public function setIsPaid(?bool $IsPaid): static
    {
        $this->IsPaid = $IsPaid;

        return $this;
    }
}
