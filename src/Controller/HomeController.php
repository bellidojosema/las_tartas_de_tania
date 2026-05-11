<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        // Buscamos todos los productos de la base de datos
        // Cambia el findAll() por esto:
        $products = $productRepository->findBy([], ['id' => 'DESC'], 6);
        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
