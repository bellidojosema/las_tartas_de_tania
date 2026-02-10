<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:create-admin', description: 'Create a default admin user for testing.')]
class CreateAdminCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $existing = $this->userRepository->findOneBy(['email' => 'admin@tartas.local']);
        if ($existing instanceof User) {
            $output->writeln('El usuario admin ya existe.');

            return Command::SUCCESS;
        }

        $user = (new User())
            ->setEmail('admin@tartas.local')
            ->setFullName('Tania Admin')
            ->setPhone('600123123')
            ->setRoles(['ROLE_ADMIN']);

        $user->setPassword($this->passwordHasher->hashPassword($user, 'Admin1234!'));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('Usuario admin creado: admin@tartas.local / Admin1234!');

        return Command::SUCCESS;
    }
}
