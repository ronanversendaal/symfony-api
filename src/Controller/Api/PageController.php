<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/page", name="api_page")
     */
    public function index()
    {
        return $this->render('api/page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
