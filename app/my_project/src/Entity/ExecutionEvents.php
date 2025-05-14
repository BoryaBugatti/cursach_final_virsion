<?php

namespace App\Entity;

use App\Repository\ExecutionEventsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExecutionEventsRepository::class)]
class ExecutionEvents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $ee_time = null;

    #[ORM\Column(length: 255)]
    private ?string $ee_status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEeTime(): ?\DateTime
    {
        return $this->ee_time;
    }

    public function setEeTime(\DateTime $ee_time): static
    {
        $this->ee_time = $ee_time;

        return $this;
    }

    public function getEeStatus(): ?string
    {
        return $this->ee_status;
    }

    public function setEeStatus(string $ee_status): static
    {
        $this->ee_status = $ee_status;

        return $this;
    }
}
