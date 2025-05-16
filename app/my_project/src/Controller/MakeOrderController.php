<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Orders;

final class MakeOrderController extends AbstractController
{
    #[Route('/api/make_order', methods:['POST'])]
    public function index(Request $request, EntityManagerInterface $entitymanager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['client_name'], $data['address'], $data['waste_type'], $data['date'], $data['time'], $data['waste_volume'])) {
            return $this->json(['status' => 'error', 'message' => 'Недостаточно данных'], 400);
        }

        $client_name = htmlspecialchars(trim($data['client_name']));
        $address = htmlspecialchars(trim($data['address']));
        $waste_type = htmlspecialchars(trim($data['waste_type']));
        
        $date = new \DateTime($data['date']);
        if (!$date) {
            return $this->json(['status' => 'error', 'message' => 'Неверный формат даты'], 400);
        }

        $time = new \DateTime ($data['time']);
        $waste_volume = htmlspecialchars(trim($data['waste_volume']));
        
        $order = new Orders();
        $order->setOrderClientName($client_name);
        $order->setOrderAddress($address);
        $order->setOrderWasteType($waste_type);
        $order->setOrderDate($date);
        $order->setOrderTime($time);
        $order->setOrderWasteVolume($waste_volume);
        
        $entitymanager->persist($order);
        $entitymanager->flush();
        
        return $this->json(['status'=> 'success']);
    }

}