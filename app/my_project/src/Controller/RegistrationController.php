<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Client;

final class RegistrationController extends AbstractController
{
    #[Route('/api/register', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $entitymanager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data) || !isset($data['username'], $data['email'], $data['password'])) {
            return $this->json(['status' => 'error', 'message' => 'Недостаточно данных'], 400);
        }
        $name = $data['username'];
        $email = $data['email'];
        $password = $data['password'];
        $address = $data['address'];
        $client = new Client();
        $client->setClientName($name);
        $client->setClientEmail($email);
        $client->setClientPassword(password_hash($password, PASSWORD_DEFAULT));
        $client->setClientAddress($address);
        $entitymanager->persist($client);
        $entitymanager->flush();
        return $this->json(['status' => 'success']);
    }
}