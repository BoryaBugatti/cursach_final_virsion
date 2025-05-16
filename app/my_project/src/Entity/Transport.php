<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $transport_number = null;

    #[ORM\Column(length: 255)]
    private ?string $transport_type = null;

    #[ORM\Column(length: 255)]
    private ?string $transport_condition = null;

    #[ORM\Column]
    private ?float $transport_capacity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransportNumber(): ?string
    {
        return $this->transport_number;
    }

    public function setTransportNumber(string $transport_number): static
    {
        $this->transport_number = $transport_number;

        return $this;
    }

    public function getTransportType(): ?string
    {
        return $this->transport_type;
    }

    public function setTransportType(string $transport_type): static
    {
        $this->transport_type = $transport_type;

        return $this;
    }

    public function getTransportCondition(): ?string
    {
        return $this->transport_condition;
    }

    public function setTransportCondition(string $transport_condition): static
    {
        $this->transport_condition = $transport_condition;

        return $this;
    }

    public function getTransportCapacity(): ?float
    {
        return $this->transport_capacity;
    }

    public function setTransportCapacity(float $transport_capacity): static
    {
        $this->transport_capacity = $transport_capacity;

        return $this;
    }
}
