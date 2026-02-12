<?php

// Activa el tipado estricto
declare(strict_types=1);

// Namespace del controlador
namespace App\Controller;

// Importaciones necesarias
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// Prefijo común de rutas -> /productos
#[Route('/productos')]
// Requiere que el usuario esté autenticado
#[IsGranted('ROLE_USER')]
class ProductController extends AbstractController
{
    // Muestra el listado de productos
    #[Route('', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        // Obtiene los productos ordenados por id descendente
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    // Crear un nuevo producto
    #[Route('/nuevo', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Se crea una entidad vacía
        $product = new Product();
        // Se genera el formulario asociado
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        // Si el formulario es válido se guarda
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'Producto creado correctamente.');

            return $this->redirectToRoute('app_product_index');
        }

        // Mostrar formulario
        return $this->render('product/new.html.twig', [
            'form' => $form,
        ]);
    }

    // Editar producto existente
    #[Route('/{id}/editar', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        // El formulario se carga con los datos actuales
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        // Si es válido se actualiza en la base de datos
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Producto actualizado correctamente.');

            return $this->redirectToRoute('app_product_index');
        }

        // Renderiza la vista de edición
        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    // Eliminar producto
    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Comprobación de seguridad CSRF
        if ($this->isCsrfTokenValid('delete_product_'.$product->getId(), (string) $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
            $this->addFlash('success', 'Producto eliminado correctamente.');
        }

        // Redirige al listado
        return $this->redirectToRoute('app_product_index');
    }
}
