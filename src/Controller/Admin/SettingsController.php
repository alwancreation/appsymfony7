<?php

namespace App\Controller\Admin;

use App\Entity\AppSettings;
use App\Helper\Utils;
use App\Services\ApplicationSettings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/settings')]
class SettingsController extends AbstractController
{

    private $em;
    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'settings_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/settings/index.html.twig', [

        ]);
    }

    #[Route('/update', name: 'settings_update', methods: ['POST'])]
    public function update(Request $request): Response
    {

        $params = $request->request->all();

        foreach (get_class_vars(ApplicationSettings::class) as $key => $var) {
            if(!isset($params[$key]) && $key!='application_logo'){
                continue;
            }
            $appSettings = $this->em->getRepository(AppSettings::class)->findOneBy(['key'=>$key]);
            if(!$appSettings){
                $appSettings = new AppSettings();
                $appSettings->setKey($key);
            }
            if($key==='application_logo'){
                if(isset($_FILES['application_logo']) && $_FILES['application_logo']['size']>10){
                    $utils = new Utils();
                    $file = new UploadedFile($_FILES['application_logo']['tmp_name'],$_FILES['application_logo']['name']);
                    $fileName = $utils->upload($file, "uploads/settings/");
                    if($fileName){
                        $appSettings->setValue($fileName);
                    }
                }
            }else{
                $appSettings->setValue($request->get($key));
            }
            $this->em->persist($appSettings);
            $this->em->flush();
        }
        return $this->redirect($this->generateUrl("settings_index"));

    }
}
