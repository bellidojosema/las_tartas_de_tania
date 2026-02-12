<?php

declare(strict_types=1);

// Namespace de la entidad
namespace App\Entity;

// Importaciones necesarias
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

// Define la clase como entidad de Doctrine y asigna su repositorio
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    // ID autogenerado de la categoría
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Nombre de la categoría, obligatorio, único, con validaciones de longitud
    #[ORM\Column(length: 80, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 80)]
    private string $name = '';

    // Descripción opcional, máximo 500 caracteres
    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Length(max: 500)]
    private ?string $description = null;

    /** @var Collection<int, Product> */
    // Relación OneToMany con Product
    #[ORM\OneToMany(mappedBy: 'categoryRef', targetEntity: Product::class)]
    private Collection $products;

    // Constructor: inicializa la colección de productos
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    // Devuelve el ID de la categoría
    public function getId(): ?int
    {
        return $this->id;
    }

    // Devuelve el nombre de la categoría
    public function getName(): string
    {
        return $this->name;
    }

    // Asigna el nombre de la categoría
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    // Devuelve la descripción de la categoría
    public function getDescription(): ?string
    {
        return $this->description;
    }

    // Asigna la descripción de la categoría
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /** @return Collection<int, Product> */
    // Devuelve la colección de productos asociados
    public function getProducts(): Collection
    {
        return $this->products;
    }
}
