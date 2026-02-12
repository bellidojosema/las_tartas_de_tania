<?php

// Fuerza el tipado estricto
declare(strict_types=1);

// Namespace del controlador
namespace App\Controller;

// Importaciones necesarias
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

// Controlador encargado del registro de nuevos usuarios
class RegistrationController extends AbstractController
{
    // Ruta para registrarse
    #[Route('/registro', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository,
    ): Response {
        // Si el usuario ya está logueado, se le redirige al listado de productos
        if ($this->getUser()) {
            return $this->redirectToRoute('app_product_index');
        }

        // Se crea una nueva entidad usuario
        $user = new User();
        // Se crea el formulario de registro
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // Si el formulario es válido
        if ($form->isSubmitted() && $form->isValid()) {
            // Comprueba si el email ya existe
            $exists = $userRepository->findOneBy(['email' => $user->getEmail()]);
            if ($exists instanceof User) {
                $this->addFlash('error', 'Ya existe una cuenta con ese correo.');

                return $this->render('security/register.html.twig', [
                    'registrationForm' => $form,
                ]);
            }

            // Obtiene la contraseña en texto plano del formulario
            $plainPassword = (string) $form->get('plainPassword')->getData();
            // La encripta antes de guardarla
            $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            // Asigna rol básico
            $user->setRoles(['ROLE_USER']);

            // Guarda el usuario en la base de datos
            $entityManager->persist($user);
            $entityManager->flush();

            // Mensaje informativo
            $this->addFlash('success', 'Registro completado. Ya puedes iniciar sesión.');

            return $this->redirectToRoute('app_login');
        }

        // Muestra el formulario
        return $this->render('security/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
