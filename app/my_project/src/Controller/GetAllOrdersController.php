<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Orders;

final class GetAllOrdersController extends AbstractController
{
    #[Route('/api/get_all_orders', methods: ['GET'])]
    public function index(EntityManagerInterface $entitymanager): JsonResponse
    {
        $orders = $entitymanager->getRepository(Orders::class)->findAll();
        return $this->json($orders);
    }
}
