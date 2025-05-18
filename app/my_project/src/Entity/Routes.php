<?php

namespace App\Entity;

use App\Repository\RoutesRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: RoutesRepository::class)]
class Routes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $route_schedule = null;

    #[ORM\ManyToOne(targetEntity: Transport::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Transport $transport = null;

    #[ORM\ManyToOne(targetEntity: SessionDriversWork::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?SessionDriversWork $driverSession = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRouteSchedule(): ?\DateTimeInterface
    {
        return $this->route_schedule;
    }

    public function setRouteSchedule(\DateTimeInterface $route_schedule): static
    {
        $this->route_schedule = $route_schedule;

        return $this;
    }

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): static
    {
        $this->transport = $transport;

        return $this;
    }

    public function getDriverSession(): ?SessionDriversWork
    {
        return $this->driverSession;
    }

    public function setDriverSession(?SessionDriversWork $driverSession): static
    {
        $this->driverSession = $driverSession;

        return $this;
    }
}