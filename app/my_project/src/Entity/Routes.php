<?php

namespace App\Entity;

use App\Repository\RoutesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoutesRepository::class)]
class Routes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $route_schedule = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRouteSchedule(): ?string
    {
        return $this->route_schedule;
    }

    public function setRouteSchedule(string $route_schedule): static
    {
        $this->route_schedule = $route_schedule;

        return $this;
    }
}
