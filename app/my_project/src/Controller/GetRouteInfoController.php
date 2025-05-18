<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Routes;

final class GetRouteInfoController extends AbstractController
{
    #[Route('/api/get_route_info', methods:['GET'])]
    public function index(EntityManagerInterface $entitymanager): JsonResponse
    {
        $routes = $entitymanager->getRepository(Routes::class)->findAll();
        return $this->json($routes);
    }
}
