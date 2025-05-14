<?php

namespace App\Entity;

use App\Repository\CollectionPointRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollectionPointRepository::class)]
class CollectionPoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cp_type = null;

    #[ORM\Column(length: 255)]
    private ?string $cp_address = null;

    #[ORM\Column]
    private ?int $cp_quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCpType(): ?string
    {
        return $this->cp_type;
    }

    public function setCpType(string $cp_type): static
    {
        $this->cp_type = $cp_type;

        return $this;
    }

    public function getCpAddress(): ?string
    {
        return $this->cp_address;
    }

    public function setCpAddress(string $cp_address): static
    {
        $this->cp_address = $cp_address;

        return $this;
    }

    public function getCpQuantity(): ?int
    {
        return $this->cp_quantity;
    }

    public function setCpQuantity(int $cp_quantity): static
    {
        $this->cp_quantity = $cp_quantity;

        return $this;
    }
}
