<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

// Clase que define el formulario de registro para la entidad User
class RegistrationFormType extends AbstractType
{
    // Construye el formulario con los campos necesarios
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Campo de texto para el nombre completo
            ->add('fullName', TextType::class, ['label' => 'Nombre completo'])
            // Campo de email para el correo electrónico
            ->add('email', EmailType::class, ['label' => 'Correo electrónico'])
            // Campo de texto opcional para el teléfono
            ->add('phone', TextType::class, ['label' => 'Teléfono', 'required' => false])
            // Campo de contraseña repetida para verificar coincidencia
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class, // Tipo de campo
                'mapped' => false, // No mapea directamente a la entidad (se hash posteriormente)
                'first_options' => ['label' => 'Contraseña'], // Primer input
                'second_options' => ['label' => 'Repetir contraseña'], // Segundo input
                'invalid_message' => 'Las contraseñas no coinciden.', // Mensaje si no coinciden
                'constraints' => [
                    new Assert\NotBlank(), // No puede estar vacío
                    new Assert\Length(min: 8), // Mínimo 8 caracteres
                ],
            ]);
    }

    // Configuración de opciones del formulario
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Este formulario manipula la entidad User
        ]);
    }
}
