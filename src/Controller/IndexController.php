<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
{
    #[Route(path: '/', name: 'app_home')]
    public function login(): Response
    {
        return $this->render('index/index.html.twig', [

        ]);
    }
}
