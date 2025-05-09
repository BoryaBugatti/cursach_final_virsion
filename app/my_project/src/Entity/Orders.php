<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $order_client_name = null;

    #[ORM\Column(length: 255)]
    private ?string $order_address = null;

    #[ORM\Column(length: 255)]
    private ?string $order_waste_type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $order_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $order_time = null;

    #[ORM\Column(length: 255)]
    private ?string $order_waste_volume = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderClientName(): ?string
    {
        return $this->order_client_name;
    }

    public function setOrderClientName(string $order_client_name): static
    {
        $this->order_client_name = $order_client_name;

        return $this;
    }

    public function getOrderAddress(): ?string
    {
        return $this->order_address;
    }

    public function setOrderAddress(string $order_address): static
    {
        $this->order_address = $order_address;

        return $this;
    }

    public function getOrderWasteType(): ?string
    {
        return $this->order_waste_type;
    }

    public function setOrderWasteType(string $order_waste_type): static
    {
        $this->order_waste_type = $order_waste_type;

        return $this;
    }

    public function getOrderDate(): ?\DateTime
    {
        return $this->order_date;
    }

    public function setOrderDate(\DateTime $order_date): static
    {
        $this->order_date = $order_date;

        return $this;
    }

    public function getOrderTime(): ?\DateTime
    {
        return $this->order_time;
    }

    public function setOrderTime(\DateTime $order_time): static
    {
        $this->order_time = $order_time;

        return $this;
    }

    public function getOrderWasteVolume(): ?string
    {
        return $this->order_waste_volume;
    }

    public function setOrderWasteVolume(string $order_waste_volume): static
    {
        $this->order_waste_volume = $order_waste_volume;

        return $this;
    }
}
