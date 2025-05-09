<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Client;
final class DownLoadAvatarUserController extends AbstractController
{
    #[Route('/api/downloadavatar', methods:['POST'])]
    public function index(Request $request, EntityManagerInterface $entitymanager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user_avatar = $data['user_avatar'];
        $user_email = $data['user_email'];
        $client = $entitymanager->getRepository(Client::class)->findOneBy(['client_email' => $user_email]);
        $client->setClientAvatar($user_avatar);
        $entitymanager->flush();
        return $this->json(['status'=> 'success']);
    }
}