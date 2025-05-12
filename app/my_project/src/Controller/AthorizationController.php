<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Client;
final class AthorizationController extends AbstractController
{
    #[Route('/api/athoriz', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entitymanager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $password = $data['password'];
        $client = $entitymanager->getRepository(Client::class)->findOneBy(['client_email'=>$email]);
        if ($client && password_verify($password, $client->getClientPassword())){
            return $this->json(['status' => 'success', 'user_name'=>$client->getClientName(), 'user_avatar' => $client->getClientAvatar(), 'user_role'=>$client->getClientRole()]);
        }
        return $this->json(['status' => 'error']);
    }
}