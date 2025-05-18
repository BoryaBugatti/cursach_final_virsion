<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?\DateTimeInterface $order_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $order_time = null;

    #[ORM\Column(length: 255)]
    private ?string $order_waste_volume = null;

    #[ORM\ManyToOne(targetEntity: Routes::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(name: 'route_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private ?Routes $route = null;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: ExecutionEvents::class, cascade: ['persist'])]
    private Collection $executionEvents;

    public function __construct()
    {
        $this->executionEvents = new ArrayCollection();
    }

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

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->order_date;
    }

    public function setOrderDate(\DateTimeInterface $order_date): static
    {
        $this->order_date = $order_date;

        return $this;
    }

    public function getOrderTime(): ?\DateTimeInterface
    {
        return $this->order_time;
    }

    public function setOrderTime(\DateTimeInterface $order_time): static
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

    public function getRoute(): ?Routes
    {
        return $this->route;
    }

    public function setRoute(?Routes $route): static
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return Collection<int, ExecutionEvents>
     */
    public function getExecutionEvents(): Collection
    {
        return $this->executionEvents;
    }

    public function addExecutionEvent(ExecutionEvents $executionEvent): static
    {
        if (!$this->executionEvents->contains($executionEvent)) {
            $this->executionEvents->add($executionEvent);
            $executionEvent->setOrder($this);
        }

        return $this;
    }

    public function removeExecutionEvent(ExecutionEvents $executionEvent): static
    {
        if ($this->executionEvents->removeElement($executionEvent)) {
            if ($executionEvent->getOrder() === $this) {
                $executionEvent->setOrder(null);
            }
        }

        return $this;
    }

    public function getRouteId(): ?int
    {
        return $this->route?->getId();
    }

    public function setRouteId(?int $route_id): self
    {
        $this->route_id = $route_id;
        return $this;
    }

    public function hasRoute(): bool
    {
        return $this->route !== null;
    }

    public function getLastEventStatus(): ?string
    {
        if ($this->executionEvents->isEmpty()) {
            return null;
        }

        $lastEvent = $this->executionEvents->last();
        return $lastEvent->getEeStatus();
    }
}