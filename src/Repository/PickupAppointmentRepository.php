<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PickupAppointment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PickupAppointment>
 */
class PickupAppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PickupAppointment::class);
    }
}
