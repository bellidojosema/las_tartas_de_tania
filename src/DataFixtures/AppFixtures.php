<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // 1. CREAR USUARIOS
        $admin = new User();
        $admin->setEmail('admin@taniatartas.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        $cliente = new User();
        $cliente->setEmail('cliente@hola.com');
        $cliente->setPassword($this->hasher->hashPassword($cliente, 'cliente123'));
        $manager->persist($cliente);

        // 2. CREAR CATEGORÍAS
        $categorias = ['Tartas de Queso', 'Repostería Creativa', 'Especial Sin Gluten', 'Galletas Artesanas'];
        $catEntities = [];

        foreach ($categorias as $nombre) {
            $category = new Category();
            $category->setName($nombre);
            $manager->persist($category);
            $catEntities[] = $category;
        }

        // 3. CREAR PRODUCTOS (TARTAS)
        $productos = [
            ['Tarta de Queso y Arándanos', 25.50, 0],
            ['Tarta Red Velvet Especial', 32.00, 1],
            ['Brownie de Chocolate Puro', 18.90, 2],
            ['Galletas de Avena y Miel', 12.00, 3],
            ['Tarta San Marcos Tradicional', 28.00, 1],
            ['Cheesecake de Pistacho', 29.90, 0],
        ];

        foreach ($productos as $datos) {
            $product = new Product();
            $product->setName($datos[0]);
            $product->setPrice($datos[1]);
            $product->setCategory($catEntities[$datos[2]]); // Asigna categoría por índice
            $manager->persist($product);
        }

        $manager->flush();
    }
}
