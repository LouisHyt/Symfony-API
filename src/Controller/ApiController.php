<?php

namespace App\Controller;

use App\Entity\Membre;
use App\HttpClient\ApiHttpClient;
use Doctrine\ORM\EntityManagerInterface;
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
            'users' => $users
        ]);
    }

    #[Route('/users/add', name: 'user_add', methods: 'POST')]
    public function addMembre(EntityManagerInterface $entityManager)
    {

        $membre = new Membre();

        $formData = [
            'title' => filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'last' => filter_input(INPUT_POST, 'last', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'first' => filter_input(INPUT_POST, 'first', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'phone' => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'picture' => filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'streetnumber' => filter_input(INPUT_POST, 'streetnumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'streetname' => filter_input(INPUT_POST, 'streetname', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'postcode' => filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'city' => filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'country' => filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ];

        if(in_array(null, $formData)){
            return $this->redirectToRoute("users_list");
            exit();
        }

        $membre->setTitle($formData['title']);
        $membre->setLast($formData['last']);
        $membre->setFirst($formData['first']);
        $membre->setEmail($formData['email']);
        $membre->setPhone($formData['phone']);
        $membre->setPicture($formData['picture']);
        $membre->setStreetnumber($formData['streetnumber']);
        $membre->setStreetname($formData['streetname']);
        $membre->setPostcode($formData['postcode']);
        $membre->setCity($formData['city']);
        $membre->setCountry($formData['country']);

        $entityManager->persist($membre);
        $entityManager->flush();

        return $this->redirectToRoute("users_list");

    }   
}
