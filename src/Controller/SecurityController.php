<?php

// Activa el tipado estricto
declare(strict_types=1);

// Namespace del controlador
namespace App\Controller;

// Importaciones necesarias
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// Controlador encargado de la autenticación (login / logout)
class SecurityController extends AbstractController
{
    // Ruta de inicio de sesión
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si el usuario ya está autenticado, lo mandamos al listado principal
        if ($this->getUser()) {
            return $this->redirectToRoute('app_product_index');
        }

        // Renderiza el formulario de login enviando:
        // - el último nombre de usuario introducido
        // - el posible error de autenticación
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    // Ruta para cerrar sesión
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony intercepta este método automáticamente mediante el firewall
        // No debe tener lógica, solo existir
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
