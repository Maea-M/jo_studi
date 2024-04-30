<?php

namespace App\Entity;

use App\Repository\QrcodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QrcodeRepository::class)]
class Qrcode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'qrcodes')]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'qrcodes')]
    private ?payement $payement = null;

    #[ORM\ManyToOne(inversedBy: 'qrcodes')]
    private ?ordersDetails $ordersDetails = null;

    #[ORM\Column(length: 255)]
    private ?string $secretKey = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPayement(): ?payement
    {
        return $this->payement;
    }

    public function setPayement(?payement $payement): static
    {
        $this->payement = $payement;

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

    public function getSecretKey(): ?string
    {
        return $this->secretKey;
    }

    public function setSecretKey(string $secretKey): static
    {
        $this->secretKey = $secretKey;

        return $this;
    }
}
