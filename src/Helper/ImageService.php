<?php
namespace App\Helper;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;

class ImageService {

    /** @var  Router */
    protected $router;
    protected $em;
    protected $container;

    public function __construct(Router $router,EntityManager $em, Container $container)
    {
        $this->router = $router;
        $this->em = $em;
        $this->container = $container;
    }

    public function getWidth($path=''){
        if(!file_exists($path)){
            return 0;
        }
        list($width, $height) = getimagesize($path);
        return $width;
    }
    public function getHeight($path=''){
        if(!file_exists($path)){
            return 0;
        }
        list($width, $height) = getimagesize($path);
        return $height;
    }


    
}

