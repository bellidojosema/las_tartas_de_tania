<?php

declare(strict_types=1);

// Namespace de la entidad
namespace App\Entity;

// Importaciones necesarias
use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

// Define la clase como entidad de Doctrine y asigna su repositorio
#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    // ID autogenerado del item
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Relación ManyToOne con Order, inversedBy 'items', eliminación en cascada
    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Order $orderRef = null;

    // Relación ManyToOne con Product
    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    // Cantidad del producto, debe ser positiva
    #[ORM\Column]
    #[Assert\Positive]
    private int $quantity = 1;

    // Precio unitario del producto, positivo o cero
    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private float $unitPrice = 0;

    // Devuelve el ID del item
    public function getId(): ?int
    {
        return $this->id;
    }

    // Devuelve la orden asociada
    public function getOrderRef(): ?Order
    {
        return $this->orderRef;
    }

    // Asigna la orden asociada
    public function setOrderRef(Order $orderRef): self
    {
        $this->orderRef = $orderRef;

        return $this;
    }

    // Devuelve el producto asociado
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    // Asigna el producto asociado
    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    // Devuelve la cantidad de productos
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    // Establece la cantidad de productos
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    // Devuelve el precio unitario
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    // Establece el precio unitario
    public function setUnitPrice(float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }
}
