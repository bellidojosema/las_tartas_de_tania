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

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nombre'])
            ->add('description', TextareaType::class, ['label' => 'Descripción'])
            ->add('category', TextType::class, ['label' => 'Categoría'])
            ->add('price', MoneyType::class, ['label' => 'Precio', 'currency' => 'EUR'])
            ->add('stock', IntegerType::class, ['label' => 'Stock'])
            ->add('imageUrl', TextType::class, ['label' => 'URL de imagen'])
            ->add('isAvailable', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
