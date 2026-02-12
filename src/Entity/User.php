<?php

declare(strict_types=1);

// Namespace de la entidad
namespace App\Entity;

// Importaciones necesarias
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

// Define la clase como entidad de Doctrine y asigna su repositorio
#[ORM\Entity(repositoryClass: UserRepository::class)]
// Nombre específico de la tabla en la base de datos
#[ORM\Table(name: 'usuario')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    // ID autogenerado del usuario
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Email del usuario, obligatorio, único y con validación de formato
    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email]
    #[Assert\NotBlank]
    private string $email = '';

    /** @var list<string> */
    // Roles del usuario almacenados como array
    #[ORM\Column]
    private array $roles = [];

    // Contraseña del usuario (hashed)
    #[ORM\Column]
    private string $password = '';

    // Nombre completo del usuario, obligatorio
    #[ORM\Column(length: 120)]
    #[Assert\NotBlank]
    private string $fullName = '';

    // Teléfono opcional del usuario
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    // Getters y setters

    // Devuelve el ID del usuario
    public function getId(): ?int
    {
        return $this->id;
    }

    // Devuelve el email del usuario
    public function getEmail(): string
    {
        return $this->email;
    }

    // Establece el email del usuario (lo convierte a minúsculas)
    public function setEmail(string $email): self
    {
        $this->email = mb_strtolower($email);

        return $this;
    }

    // Identificador único del usuario para Symfony (email)
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /** @return list<string> */
    // Devuelve los roles del usuario, siempre incluyendo ROLE_USER
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_values(array_unique($roles));
    }

    /** @param list<string> $roles */
    // Establece los roles del usuario
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    // Devuelve la contraseña encriptada
    public function getPassword(): string
    {
        return $this->password;
    }

    // Establece la contraseña encriptada
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    // Método requerido por UserInterface para limpiar datos sensibles (no usado aquí)
    public function eraseCredentials(): void
    {
    }

    // Devuelve el nombre completo del usuario
    public function getFullName(): string
    {
        return $this->fullName;
    }

    // Establece el nombre completo del usuario
    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    // Devuelve el teléfono del usuario
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    // Establece el teléfono del usuario
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
