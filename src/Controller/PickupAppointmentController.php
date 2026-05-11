<?php

namespace App\Controller;

use App\Entity\PickupAppointment;
use App\Form\PickupAppointmentType;
use App\Repository\PickupAppointmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pickup/appointment')]
final class PickupAppointmentController extends AbstractController
{
    #[Route(name: 'app_pickup_appointment_index', methods: ['GET'])]
    public function index(PickupAppointmentRepository $pickupAppointmentRepository): Response
    {
        return $this->render('pickup_appointment/index.html.twig', [
            'pickup_appointments' => $pickupAppointmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pickup_appointment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pickupAppointment = new PickupAppointment();
        $form = $this->createForm(PickupAppointmentType::class, $pickupAppointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pickupAppointment);
            $entityManager->flush();

            return $this->redirectToRoute('app_pickup_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pickup_appointment/new.html.twig', [
            'pickup_appointment' => $pickupAppointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pickup_appointment_show', methods: ['GET'])]
    public function show(PickupAppointment $pickupAppointment): Response
    {
        return $this->render('pickup_appointment/show.html.twig', [
            'pickup_appointment' => $pickupAppointment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pickup_appointment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PickupAppointment $pickupAppointment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PickupAppointmentType::class, $pickupAppointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pickup_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pickup_appointment/edit.html.twig', [
            'pickup_appointment' => $pickupAppointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pickup_appointment_delete', methods: ['POST'])]
    public function delete(Request $request, PickupAppointment $pickupAppointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pickupAppointment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($pickupAppointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pickup_appointment_index', [], Response::HTTP_SEE_OTHER);
    }
}
