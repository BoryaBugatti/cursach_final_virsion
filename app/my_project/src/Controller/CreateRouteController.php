<?php

namespace App\Controller;

use App\Entity\Routes;
use App\Entity\Transport;
use App\Entity\SessionDriversWork;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateRouteController extends AbstractController
{
    #[Route('/api/create_route', methods: ['POST'])]
    public function index(EntityManagerInterface $entityManager, Request $request, ValidatorInterface $validator ): JsonResponse 
    {
        if (empty($request->getContent())) {
            return $this->json([
                'status' => 'error',
                'message' => 'Empty request body'
            ], 400);
        }

        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['route_schedule'], $data['transport_id'], $data['driver_session_id'])) {
            return $this->json([
                'status' => 'error',
                'message' => 'Missing required fields: route_schedule, transport_id, driver_session_id'
            ], 400);
        }

        $transport = $entityManager->getRepository(Transport::class)->find($data['transport_id']);
        if (!$transport) {
            return $this->json([
                'status' => 'error',
                'message' => 'Transport not found'
            ], 404);
        }

        if ($transport->getTransportCondition() !== 'свободен') {
            return $this->json([
                'status' => 'error',
                'message' => 'Transport is not available',
                'current_status' => $transport->getTransportCondition()
            ], 400);
        }

        $driver = $entityManager->getRepository(SessionDriversWork::class)->find($data['driver_session_id']);
        if (!$driver) {
            return $this->json([
                'status' => 'error',
                'message' => 'Driver not found'
            ], 404);
        }

        $route = new Routes();
        try {
            $route->setRouteSchedule(new \DateTime($data['route_schedule']));
            $route->setTransport($transport);
            $route->setDriverSession($driver);
            $errors = $validator->validate($route);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }
                
                return $this->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $errorMessages
                ], 422);
            }
            $entityManager->beginTransaction();
            $transport->setTransportCondition('занят');
            $entityManager->persist($transport);
            $entityManager->persist($route);
            $entityManager->flush();
            $entityManager->commit();

            return $this->json([
                'status' => 'success',
                'message' => 'Route created successfully',
                'route_id' => $route->getId()
            ]);
            
        } catch (\Exception $e) {
            if ($entityManager->getConnection()->isTransactionActive()) {
                $entityManager->rollback();
            }
            
            return $this->json([
                'status' => 'error',
                'message' => 'Failed to create route',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}