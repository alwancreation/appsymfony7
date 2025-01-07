<?php
namespace App\Services;

use App\Entity\AppSettings;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\RouterInterface;

class ApplicationSettings{
    /** @var  Router */
    protected $router;
    protected $em;

    public $application_name='Application Name';
    public $application_about='About Application';
    public $application_email='info@example.com';
    public $application_phone='06 87 98 65 98';
    public $application_site=null;
    public $application_address=null;
    public $application_location='Marrakech Morocco';
    public $application_gsm=null;
    public $application_logo=null;
    public $application_description=null;

    public $application_facebook='http://www.facebook.com';
    public $application_youtube='http://www.youtube.com';
    public $application_instagram='http://www.instagram.com';
    public $application_twitter='';
    public $application_linkedin='';
    public $application_pinterest='';
    public $application_viadeo='';
    public $application_telegram='';
    public $application_tiktok='';


    public function __construct(RouterInterface $router,EntityManagerInterface $em)
    {
        $this->router = $router;
        $this->em = $em;

        $appSettings = $this->em->getRepository(AppSettings::class)->findAll();
        foreach ($appSettings as $appSettingLine){
            $this->{$appSettingLine->getKey()} = $appSettingLine->getValue();
        }
    }

}

