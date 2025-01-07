<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class IndexController  extends AbstractController {
    private $em;
    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'admin_default_index', methods: ['GET'])]
    public function index()
    {
        return $this->render("admin/index/index.html.twig");
    }

}