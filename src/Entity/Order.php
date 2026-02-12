<?php

declare(strict_types=1);

// Namespace de la entidad
namespace App\Entity;

// Importaciones necesarias
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

// Define la clase como entidad de Doctrine y asigna su repositorio
#[ORM\Entity(repositoryClass: OrderRepository::class)]
// Define el nombre de la tabla en la base de datos
#[ORM\Table(name: 'order')]
class Order
{
    // ID autogenerado de la orden
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Relación ManyToOne con User (cliente)
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $customer = null;

    // Fecha y hora de creación de la orden
    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    // Estado de la orden con valores permitidos
    #[ORM\Column(length: 40)]
    #[Assert\Choice(['pendiente', 'confirmado', 'entregado', 'cancelado'])]
    private string $status = 'pendiente';

    // Total de la orden, debe ser positivo o cero
    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private float $total = 0;

    /** @var Collection<int, OrderItem> */
    // Relación OneToMany con OrderItem, con persistencia y eliminación en cascada
    #[ORM\OneToMany(mappedBy: 'orderRef', targetEntity: OrderItem::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $items;

    // Constructor: inicializa la fecha de creación y la colección de items
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->items = new ArrayCollection();
    }

    // Devuelve el ID de la orden
    public function getId(): ?int
    {
        return $this->id;
    }

    // Devuelve el cliente asociado
    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    // Asigna un cliente a la orden
    public function setCustomer(User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    // Devuelve la fecha de creación
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    // Devuelve el estado de la orden
    public function getStatus(): string
    {
        return $this->status;
    }

    // Cambia el estado de la orden
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    // Devuelve el total de la orden
    public function getTotal(): float
    {
        return $this->total;
    }

    // Establece el total de la orden
    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /** @return Collection<int, OrderItem> */
    // Devuelve la colección de items asociados a la orden
    public function getItems(): Collection
    {
        return $this->items;
    }
}
