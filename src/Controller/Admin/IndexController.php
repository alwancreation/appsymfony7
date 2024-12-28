<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
{
    #[Route(path: '/', name: 'admin_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [

        ]);
    }
}
