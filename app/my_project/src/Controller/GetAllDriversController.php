<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SessionDriversWork;

final class GetAllDriversController extends AbstractController
{
    #[Route('/api/get_all_drivers', methods: ['GET'])]
    public function index(EntityManagerInterface $entitymanager): JsonResponse
    {
       $drivers = $entitymanager->getRepository(SessionDriversWork::class)->findAll();
       return $this->json($drivers);
    }
}
