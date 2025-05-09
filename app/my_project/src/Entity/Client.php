<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $client_name = null;

    #[ORM\Column(length: 255)]
    private ?string $client_email = null;

    #[ORM\Column(length: 255)]
    private ?string $client_password = null;

    #[ORM\Column(length: 255)]
    private ?string $client_address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $client_avatar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->client_name;
    }

    public function setClientName(string $client_name): static
    {
        $this->client_name = $client_name;

        return $this;
    }

    public function getClientEmail(): ?string
    {
        return $this->client_email;
    }

    public function setClientEmail(string $client_email): static
    {
        $this->client_email = $client_email;

        return $this;
    }

    public function getClientPassword(): ?string
    {
        return $this->client_password;
    }

    public function setClientPassword(string $client_password): static
    {
        $this->client_password = $client_password;

        return $this;
    }

    public function getClientAddress(): ?string
    {
        return $this->client_address;
    }

    public function setClientAddress(string $client_address): static
    {
        $this->client_address = $client_address;

        return $this;
    }

    public function getClientAvatar(): ?string
    {
        return $this->client_avatar;
    }

    public function setClientAvatar(?string $client_avatar): static
    {
        $this->client_avatar = $client_avatar;

        return $this;
    }
}
