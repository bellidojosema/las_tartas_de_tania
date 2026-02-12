<?php

namespace App\Form;

use App\Entity\PickupAppointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Clase que define el formulario para la entidad PickupAppointment
class PickupAppointmentType extends AbstractType
{
    // Construye el formulario con los campos necesarios
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Campo de fecha y hora de la quedada
            ->add('pickupAt', DateTimeType::class, [
                'widget' => 'single_text', // Muestra un solo input tipo datetime
                'input' => 'datetime_immutable', // Crucial: coincide con la propiedad de la entidad
                'label' => '¿Cuándo quedamos?',
                'attr' => ['class' => 'form-control'] // Clase CSS para bootstrap
            ])
            // Campo de selección del estado de la quedada
            ->add('status', ChoiceType::class, [
                'label' => 'Estado de la Quedada',
                'choices' => [
                    'Programada' => 'programada',
                    'Realizada' => 'realizada',
                    'Cancelada' => 'cancelada',
                ],
                'attr' => ['class' => 'form-select'] // Clase CSS para bootstrap
            ])
            // Campo de notas o detalles adicionales
            ->add('notes', TextareaType::class, [
                'label' => 'Detalles o Lugar',
                'required' => false, // No obligatorio
                'attr' => [
                    'class' => 'form-control', // Clase CSS
                    'placeholder' => 'Ej: En la puerta de la pastelería...' // Placeholder de ejemplo
                ]
            ]);
    }

    // Configuración de opciones del formulario
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PickupAppointment::class, // Este formulario manipula la entidad PickupAppointment
        ]);
    }
}
