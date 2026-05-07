<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\PickupAppointment;
use App\Form\OrderType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout')]
    public function index(
        Request $request,
        SessionInterface $session,
        ProductRepository $productRepository,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $cart = $session->get('cart', []);
        if (empty($cart)) {
            return $this->redirectToRoute('app_product_index');
        }

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            // 1. Crear la Cita (PickupAppointment) siguiendo tu entidad
            $locationName = $form->get('pickupLocation')->getData();
            $appointment = new PickupAppointment();
            $appointment->setLocation($locationName); // Usamos setLocation
            $appointment->setDate(new \DateTime('+2 days')); // Usamos setDate
            $appointment->setUser($user); // Es obligatorio en tu entidad

            // 2. Configurar el Pedido (Order)
            $order->setUser($user);
            $order->setOrderNumber('TANIA-' . strtoupper(bin2hex(random_bytes(3))));
            $order->setCreatedAt(new \DateTimeImmutable());
            $order->setPickupAppointment($appointment); // Relación 1:1

            // 3. Crear los items del pedido
            foreach ($cart as $id => $quantity) {
                $product = $productRepository->find($id);
                if ($product) {
                    $item = new OrderItem();
                    $item->setProduct($product);
                    $item->setQuantity($quantity);
                    $item->setOrder($order);
                    $em->persist($item);
                }
            }

            $em->persist($appointment);
            $em->persist($order);
            $em->flush();

            $session->remove('cart');
            $this->addFlash('success', '¡Pedido confirmado! Gracias por confiar en las manos de Tania.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('checkout/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
