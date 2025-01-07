<?php
namespace App\Helper;

use App\Entity\AppSettings;
use App\Entity\Page;
use App\Entity\Product;
use App\Entity\Settings;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;

class SeoService{
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
    public function getMeta(){
        $settings = $this->em->getRepository(AppSettings::class)->findAll();
        $settingsObject = new \stdClass();
        /** @var Settings $setting */
        foreach ($settings as $setting){
            $settingsObject->{$setting->getKey()} = $setting->getValue();
        }

        return '
        <title>'.$settingsObject->application_name.'</title>
        <meta name="description" content="'.$settingsObject->application_description.'">
        <meta property="og:title" content="'.$settingsObject->application_name.'"/>
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="'.$settingsObject->application_description.'"/>
        ';

    }

    public function metaProduct(Product $product){
        $settings = $this->em->getRepository(AppSettings::class)->findAll();
        $settingsObject = new \stdClass();
        /** @var Settings $setting */
        foreach ($settings as $setting){
            $settingsObject->{$setting->getKey()} = $setting->getValue();
        }

        return '
        <title>'.$product->getProductName().' - '.$settingsObject->application_name.'</title>
        <meta name="description" content="'.substr($product->getProductShortDescription(),0,200).'">
        <meta property="og:title" content="'.$product->getProductName().' - '.$settingsObject->application_name.'"/>
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="'.substr($product->getProductShortDescription(),0,200).'"/>
        ';

    }
    public function metaPage(Page $page){
        $meta = $page->getMeta();
        if($meta){
            return '
            <title>'.$meta->getMetaTitle().'</title>
            <meta name="description" content="'.$meta->getMetaDescription().'">
            <meta name="keywords" content="'.$meta->getMetaKeywords().'">
            '.$meta->getMetaPlus();
        }
        return $this->getMeta();

    }

    
}

