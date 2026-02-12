<?php

declare(strict_types=1);

// Namespace de la entidad
namespace App\Entity;

// Importaciones necesarias
use App\Repository\PickupAppointmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

// Define la clase como entidad de Doctrine y asigna su repositorio
#[ORM\Entity(repositoryClass: PickupAppointmentRepository::class)]
// Opcional: nombre específico de la tabla en la base de datos
#[ORM\Table(name: 'pickup_appointment')]
class PickupAppointment
{
    // ID autogenerado de la quedada
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * IMPORTANTE: Aquí forzamos que el campo se llame user_id
     * y que haga referencia al id de la tabla 'usuario' (definido en la entidad User)
     */
    // Relación ManyToOne con User
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(
        name: 'user_id',            // Nombre de la columna en esta tabla
        referencedColumnName: 'id', // Columna en la tabla destino (User)
        nullable: false,
        onDelete: 'CASCADE'         // Si se borra el usuario, se borra la quedada
    )]
    private ?User $user = null;

    // Fecha y hora de la quedada, obligatoria
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\NotNull(message: "La fecha de la quedada es obligatoria.")]
    private ?\DateTimeImmutable $pickupAt = null;

    // Estado de la quedada, con opciones válidas
    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['programada', 'realizada', 'cancelada'], message: "Estado no válido.")]
    private string $status = 'programada';

    // Notas opcionales de la quedada, máximo 500 caracteres
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(max: 500)]
    private ?string $notes = null;

    // Getters y setters

    // Devuelve el ID de la quedada
    public function getId(): ?int
    {
        return $this->id;
    }

    // Devuelve el usuario asociado
    public function getUser(): ?User
    {
        return $this->user;
    }

    // Asigna el usuario asociado
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    // Devuelve la fecha y hora de la quedada
    public function getPickupAt(): ?\DateTimeImmutable
    {
        return $this->pickupAt;
    }

    // Asigna la fecha y hora de la quedada
    public function setPickupAt(?\DateTimeImmutable $pickupAt): self
    {
        $this->pickupAt = $pickupAt;
        return $this;
    }

    // Devuelve el estado de la quedada
    public function getStatus(): string
    {
        return $this->status;
    }

    // Cambia el estado de la quedada
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    // Devuelve las notas de la quedada
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    // Asigna las notas de la quedada
    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }
}
