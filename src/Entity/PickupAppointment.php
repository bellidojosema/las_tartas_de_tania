<?php

namespace App\Entity;

use App\Repository\PickupAppointmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PickupAppointmentRepository::class)]
class PickupAppointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'pickupAppointments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'pickupAppointment', targetEntity: Order::class)]
    private ?Order $order = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        // Esto asegura que la relación bidireccional se mantenga sincronizada
        if ($order !== null && $order->getPickupAppointment() !== $this) {
            $order->setPickupAppointment($this);
        }

        $this->order = $order;
        return $this;
    }

    // Método para mostrar la cita fácilmente en formularios o listas
    public function __toString(): string
    {
        return $this->date->format('d/m/Y H:i') . ' - ' . $this->location;
    }
}
