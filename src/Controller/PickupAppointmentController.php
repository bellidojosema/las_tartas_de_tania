<?php

// Espacio de nombres del controlador
namespace App\Controller;

// Importaciones necesarias
use App\Entity\PickupAppointment;
use App\Form\PickupAppointmentType;
use App\Repository\PickupAppointmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// Prefijo común para todas las rutas del controlador
#[Route('/quedadas')]
// Solo los usuarios autenticados con ROLE_USER pueden acceder
#[IsGranted('ROLE_USER')]
class PickupAppointmentController extends AbstractController
{
    // Lista todas las quedadas
    #[Route('/', name: 'app_pickup_appointment_index', methods: ['GET'])]
    public function index(PickupAppointmentRepository $repo): Response
    {
        // Renderiza la vista enviando todas las citas almacenadas
        return $this->render('pickup_appointment/index.html.twig', [
            'appointments' => $repo->findAll(),
        ]);
    }

    // Crear una nueva quedada
    #[Route('/nueva', name: 'app_pickup_appointment_new', methods: ['GET', 'POST'])]
    // Solo administradores pueden crear
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        // Se crea la entidad vacía
        $quedada = new PickupAppointment();

        // Importante: Asignar el usuario actual ANTES de crear el formulario
        $quedada->setUser($this->getUser());

        // Se crea el formulario asociado a la entidad
        $form = $this->createForm(PickupAppointmentType::class, $quedada);
        $form->handleRequest($request);

        // Si el formulario se envía y es válido
        if ($form->isSubmitted() && $form->isValid()) {
            // Doble comprobación para evitar el error de Integrity Constraint
            if (null === $quedada->getUser()) {
                $quedada->setUser($this->getUser());
            }

            // Guardar en base de datos
            $em->persist($quedada);
            $em->flush();

            // Mensaje para el usuario
            $this->addFlash('success', '¡Nueva quedada organizada!');
            return $this->redirectToRoute('app_pickup_appointment_index');
        }

        // Mostrar el formulario
        return $this->render('pickup_appointment/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Editar una quedada existente
    #[Route('/{id}/editar', name: 'app_pickup_appointment_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, PickupAppointment $quedada, EntityManagerInterface $em): Response
    {
        // Se reutiliza el formulario con los datos actuales
        $form = $this->createForm(PickupAppointmentType::class, $quedada);
        $form->handleRequest($request);

        // Si es válido, se guardan los cambios
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Quedada actualizada correctamente.');
            return $this->redirectToRoute('app_pickup_appointment_index');
        }

        // Renderiza la vista de edición
        return $this->render('pickup_appointment/edit.html.twig', [
            'quedada' => $quedada,
            'form' => $form->createView(),
        ]);
    }

    // Eliminar una quedada
    #[Route('/{id}/eliminar', name: 'app_pickup_appointment_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, PickupAppointment $quedada, EntityManagerInterface $em): Response
    {
        // Verifica el token CSRF para seguridad
        if ($this->isCsrfTokenValid('delete'.$quedada->getId(), $request->request->get('_token'))) {
            // Borra la entidad de la base de datos
            $em->remove($quedada);
            $em->flush();
            $this->addFlash('success', 'Quedada eliminada.');
        }

        // Redirige al listado
        return $this->redirectToRoute('app_pickup_appointment_index');
    }
}
