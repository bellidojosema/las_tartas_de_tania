<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pickupLocation', ChoiceType::class, [
                'label' => 'Selecciona el punto de recogida',
                'mapped' => false,
                'choices'  => [
                    'Obrador (Calle Falsa 123)' => 'Obrador',
                    'Mercadillo Local (Domingos)' => 'Mercadillo',
                    'Recogida en Tienda Colaboradora' => 'Tienda',
                ],
                'attr' => ['class' => 'form-select']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
