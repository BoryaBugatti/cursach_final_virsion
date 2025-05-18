<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Orders;

final class PatchRouteIdInOrderController extends AbstractController
{
    #[Route('/api/update_route_id_in_order', methods:['PATCH'])]
    public function index(Request $request, EntityManagerInterface $entitymanager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $route_id = $data['route_id'];
        $order_id = $data['order_id'];
        $order = $entitymanager->getRepository(Orders::class)->find($order_id);
        $order->setRouteId($route_id);
        $entitymanager->flush();
        return $this->json(['message' => 'Route _Id был успешно обновлен']);
    }
}