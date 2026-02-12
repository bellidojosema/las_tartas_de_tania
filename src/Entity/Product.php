<?php

declare(strict_types=1);

// Namespace de la entidad
namespace App\Entity;

// Importaciones necesarias
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

// Define la clase como entidad de Doctrine y asigna su repositorio
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    // ID autogenerado del producto
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Nombre del producto, obligatorio, con longitud mínima 3 y máxima 120
    #[ORM\Column(length: 120)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 120)]
    private string $name = '';

    // Descripción del producto, obligatoria, mínimo 10 caracteres
    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 10)]
    private string $description = '';

    // Nombre de la categoría (texto), obligatorio
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private string $category = '';

    // Relación ManyToOne con la entidad Category, opcional, si se borra la categoría se pone a null
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Category $categoryRef = null;

    // Precio del producto, positivo
    #[ORM\Column]
    #[Assert\Positive]
    private float $price = 1.0;

    // Stock del producto, positivo o cero
    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private int $stock = 0;

    // URL de la imagen del producto, obligatoria y válida
    #[ORM\Column(length: 255)]
    #[Assert\Url]
    private string $imageUrl = '';

    // Disponibilidad del producto
    #[ORM\Column(type: 'boolean')]
    private bool $isAvailable = true;

    // Getters y setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }
}
