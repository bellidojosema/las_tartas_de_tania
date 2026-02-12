<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Clase que define el formulario para la entidad Product
class ProductType extends AbstractType
{
    // Construye el formulario con los campos necesarios
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Campo de texto para el nombre del producto
            ->add('name', TextType::class, ['label' => 'Nombre'])
            // Campo de textarea para la descripción del producto
            ->add('description', TextareaType::class, ['label' => 'Descripción'])
            // Campo de texto para la categoría del producto (nombre como texto)
            ->add('category', TextType::class, ['label' => 'Categoría'])
            // Campo de tipo Money para el precio, en euros
            ->add('price', MoneyType::class, ['label' => 'Precio', 'currency' => 'EUR'])
            // Campo de tipo entero para el stock
            ->add('stock', IntegerType::class, ['label' => 'Stock'])
            // Campo de tipo checkbox para disponibilidad
            ->add('isAvailable', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false, // No obligatorio
            ]);
    }

    // Configuración de opciones del formulario
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class, // Este formulario manipula la entidad Product
        ]);
    }
}
