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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ee_time = null;

    #[ORM\Column(length: 255)]
    private ?string $ee_status = null;

    #[ORM\ManyToOne(targetEntity: Orders::class, inversedBy: 'executionEvents')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Orders $order = null;

    #[ORM\ManyToOne(targetEntity: Routes::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Routes $route = null;

    public function __construct()
    {
        $this->ee_time = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEeTime(): ?\DateTimeInterface
    {
        return $this->ee_time;
    }

    public function setEeTime(\DateTimeInterface $ee_time): static
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

    public function getOrder(): ?Orders
    {
        return $this->order;
    }

    public function setOrder(?Orders $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getRoute(): ?Routes
    {
        return $this->route;
    }

    public function setRoute(?Routes $route): static
    {
        $this->route = $route;

        return $this;
    }

    public function getOrderId(): ?int
    {
        return $this->order?->getId();
    }

    public function getRouteId(): ?int
    {
        return $this->route?->getId();
    }

    public function getFormattedEeTime(): string
    {
        return $this->ee_time ? $this->ee_time->format('Y-m-d H:i:s') : '';
    }
}