<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * Endpoint for all users
     * @Route("/api/users", name="app_api_user_getUsers", methods={"GET"})
     */
    public function getUsers(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();
        
        return $this->json($users, Response::HTTP_OK, [], ["groups" => "users"]);
    }
}
