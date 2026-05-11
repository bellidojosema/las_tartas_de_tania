<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'user')]
    private Collection $orders;

    /**
     * @var Collection<int, PickupAppointment>
     */
    #[ORM\OneToMany(targetEntity: PickupAppointment::class, mappedBy: 'user')]
    private Collection $pickupAppointments;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->pickupAppointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUser($this);
        }
        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, PickupAppointment>
     */
    public function getPickupAppointments(): Collection
    {
        return $this->pickupAppointments;
    }

    public function addPickupAppointment(PickupAppointment $pickupAppointment): static
    {
        if (!$this->pickupAppointments->contains($pickupAppointment)) {
            $this->pickupAppointments->add($pickupAppointment);
            $pickupAppointment->setUser($this);
        }
        return $this;
    }

    public function removePickupAppointment(PickupAppointment $pickupAppointment): static
    {
        if ($this->pickupAppointments->removeElement($pickupAppointment)) {
            if ($pickupAppointment->getUser() === $this) {
                $pickupAppointment->setUser(null);
            }
        }
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Si guardas datos temporales sensibles, bórralos aquí
    }
}
