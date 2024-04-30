<?php

namespace App\Entity;

use App\Repository\OrdersDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersDetailsRepository::class)]
class OrdersDetails
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\ManyToOne(targetEntity: Orders::class, inversedBy: 'ordersDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private $orders;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'ordersDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private $evenement;

    #[ORM\Column(type: 'boolean')]
    private ?bool $IsPaid = false;

    #[ORM\ManyToOne(inversedBy: 'ordersDetails')]
    private ?Payement $payement = null;

    #[ORM\OneToMany(targetEntity: Qrcode::class, mappedBy: 'ordersDetails')]
    private Collection $qrcodes;

    public function __construct()
    {
        $this->qrcodes = new ArrayCollection();
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

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

    public function getPayement(): ?Payement
    {
        return $this->payement;
    }

    public function setPayement(?Payement $payement): static
    {
        $this->payement = $payement;

        return $this;
    }

    /**
     * @return Collection<int, Qrcode>
     */
    public function getQrcodes(): Collection
    {
        return $this->qrcodes;
    }

    public function addQrcode(Qrcode $qrcode): static
    {
        if (!$this->qrcodes->contains($qrcode)) {
            $this->qrcodes->add($qrcode);
            $qrcode->setOrdersDetails($this);
        }

        return $this;
    }

    public function removeQrcode(Qrcode $qrcode): static
    {
        if ($this->qrcodes->removeElement($qrcode)) {
            // set the owning side to null (unless already changed)
            if ($qrcode->getOrdersDetails() === $this) {
                $qrcode->setOrdersDetails(null);
            }
        }

        return $this;
    }

}
