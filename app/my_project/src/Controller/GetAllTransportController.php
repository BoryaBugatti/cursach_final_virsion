<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Transport;

final class GetAllTransportController extends AbstractController
{
    #[Route('/api/get_all_transport', methods: ['GET'])]
    public function index(EntityManagerInterface $entitymanager): JsonResponse
    {
        $transports = $entitymanager->getRepository(Transport::class)->findAll();
        return $this->json($transports);
    }
}
