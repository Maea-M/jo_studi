<?php

namespace App\Entity;

use App\Repository\PayementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayementRepository::class)]
class Payement
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $SecondKey = null;

    #[ORM\ManyToOne(inversedBy: 'payements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\OneToMany(mappedBy: 'payement', targetEntity: OrdersDetails::class)]
    private Collection $ordersDetails;

    public function __construct()
    {
        $this->ordersDetails = new ArrayCollection();
    }
    #[ORM\Column]
    private ?bool $IsPaid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSecondKey(): ?string
    {
        return $this->SecondKey;
    }

    public function setSecondKey(?string $SecondKey): static
    {
        $this->SecondKey = $SecondKey;

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

    /**
     * @return Collection<int, OrdersDetails>
     */
    public function getOrdersDetails(): Collection
    {
        return $this->ordersDetails;
    }

    public function addOrdersDetail(OrdersDetails $ordersDetails): static
    {
        if (!$this->ordersDetails->contains($ordersDetails)) {
            $this->ordersDetails->add($ordersDetails);
            $ordersDetails->setPayement($this);
        }

        return $this;
    }

    public function removeOrdersDetails(OrdersDetails $ordersDetails): static
    {
        if ($this->ordersDetails->removeElement($ordersDetails)) {
            // set the owning side to null (unless already changed)
            if ($ordersDetails->getPayement() === $this) {
                $ordersDetails->setPayement(null);
            }
        }

        return $this;
    }
    public function isIsPaid(): ?bool
    {
        return $this->IsPaid;
    }

    public function setIsPaid(bool $IsPaid): static
    {
        $this->IsPaid = $IsPaid;

        return $this;
    }

}
