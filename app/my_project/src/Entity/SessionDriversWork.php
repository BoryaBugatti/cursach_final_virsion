<?php

namespace App\Entity;

use App\Repository\SessionDriversWorkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionDriversWorkRepository::class)]
class SessionDriversWork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $driver_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDriverName(): ?string
    {
        return $this->driver_name;
    }

    public function setDriverName(string $driver_name): static
    {
        $this->driver_name = $driver_name;

        return $this;
    }
}
