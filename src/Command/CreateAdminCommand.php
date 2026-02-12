<?php

// Obliga a que PHP use tipado estricto para evitar conversiones automáticas de tipos
declare(strict_types=1);

// Espacio de nombres donde se ubica el comando dentro de la aplicación
namespace App\Command;

// Importaciones de clases necesarias
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// Define este archivo como un comando ejecutable desde la consola de Symfony
#[AsCommand(name: 'app:create-admin', description: 'Create a default admin user for testing.')]
class CreateAdminCommand extends Command
{
    // Inyección de dependencias mediante el constructor
    public function __construct(
        private readonly EntityManagerInterface $entityManager, // Para guardar en base de datos
        private readonly UserRepository $userRepository,       // Para consultar usuarios
        private readonly UserPasswordHasherInterface $passwordHasher, // Para encriptar la contraseña
    ) {
        parent::__construct();
    }

    // Método que se ejecuta cuando lanzamos el comando
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Busca si ya existe un usuario con el email indicado
        $existing = $this->userRepository->findOneBy(['email' => 'admin@tartas.local']);
        if ($existing instanceof User) {
            // Si existe, muestra mensaje y termina correctamente
            $output->writeln('El usuario admin ya existe.');

            return Command::SUCCESS;
        }

        // Si no existe, crea un nuevo usuario con datos por defecto
        $user = (new User())
            ->setEmail('admin@tartas.local')
            ->setFullName('Tania Admin')
            ->setPhone('600123123')
            ->setRoles(['ROLE_ADMIN']);

        // Genera el hash de la contraseña antes de guardarla
        $user->setPassword($this->passwordHasher->hashPassword($user, 'Admin1234!'));

        // Indica a Doctrine que debe guardar el usuario
        $this->entityManager->persist($user);
        // Ejecuta la inserción en la base de datos
        $this->entityManager->flush();

        // Mensaje informativo final
        $output->writeln('Usuario admin creado: admin@tartas.local / Admin1234!');

        return Command::SUCCESS;
    }
}
