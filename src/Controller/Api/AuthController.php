<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/auth", name="api_auth")
     */
    public function index()
    {
        return $this->render('api/auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
}
