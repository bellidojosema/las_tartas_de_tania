<?php

// Activa el tipado estricto en PHP
declare(strict_types=1);

// Espacio de nombres del controlador
namespace App\Controller;

// Clases que se utilizan dentro del controlador
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Controlador principal que hereda funcionalidades base de Symfony
class HomeController extends AbstractController
{
    // Define la ruta raíz del sitio web "/"
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Renderiza la plantilla Twig ubicada en templates/home/index.html.twig
        return $this->render('home/index.html.twig');
    }
}
