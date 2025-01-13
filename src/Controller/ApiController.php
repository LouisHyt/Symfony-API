<?php

namespace App\Controller;

use App\HttpClient\ApiHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route('/users', name: 'users_list')]
    public function index(ApiHttpClient $apiHttpClient): Response
    {

        $users = $apiHttpClient->getUsers();
        return $this->render('users/index.html.twig', [
            'users' => $users,
        ]);
    }
}
