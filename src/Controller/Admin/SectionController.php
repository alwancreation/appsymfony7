<?php

namespace App\Controller\Admin;

use App\Entity\Asset;
use App\Entity\Page;
use App\Entity\Section;
use App\Helper\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/sections')]
class SectionController extends AbstractController
{

    private $em;
    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'section_index', methods: ['GET'])]
    public function indexAction()
    {


        $sections = $this->em->getRepository('AppBundle:Section')->findAll();

        return $this->render('admin/section/index.html.twig', array(
            'sections' => $sections,
        ));
    }

    #[Route('/new/page/{id}', name: 'section_new', methods: ['GET', 'POST'])]
    public function newAction(Request $request, Page $page)
    {
        $editable_lang = $request->get('lang',"en");
        $section = new Section();
        $form = $this->createForm('App\Form\SectionType', $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            if ($section->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($section->getAssetFile(), "uploads/images/home/");
                $asset->setAssetBasePath($imageFileName);
                $section->setMainAsset($asset);
            }
            if($section->getRemoveAsset()){
                $section->setMainAsset(null);
            }
            $section->setPage($page);

            $this->em->persist($section);
            $this->em->flush($section);

            return $this->redirectToRoute('pages_edit',["id"=>$page->getPageId()]);
        }

        return $this->render('admin/section/new.html.twig', array(
            'editable_lang' => $editable_lang,
            'section' => $section,
            'page' => $page,
            'form' => $form->createView(),
        ));
    }


    #[Route('/{lang}/{id}', name: 'section_show', methods: ['GET'])]
    public function editAction(Request $request, Section $section)
    {

        $editable_lang = $request->get('lang',"en");

        $deleteForm = $this->createDeleteForm($section);
        $editForm = $this->createForm('App\Form\SectionType', $section);
        


        $assetNew = new Asset();
        $formType = 'App\Form\AssetSectionType';
        if($section->getSectionType()==3){
            //$formType = 'App\Form\AssetSectionProductsType';
        }
        $assetForm = $this->createForm($formType, $assetNew, array(
            'action' => $this->generateUrl('section_add_asset',array("id"=>$section->getSectionId())),
            'method' => 'POST',
        ));

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($section->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($section->getAssetFile(), "uploads/images/home/");
                $asset->setAssetBasePath($imageFileName);
                $section->setMainAsset($asset);
            }
            if($section->getRemoveAsset()){
                $section->setMainAsset(null);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('section_edit', array('id' => $section->getSectionId(),"lang"=>$editable_lang));
        }

        return $this->render('admin/section/edit.html.twig', array(
            'section' => $section,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'assetForm' => $assetForm->createView(),
            'editable_lang' => $editable_lang,
        ));
    }


    #[Route('/{lang}/{id}/duplicate', name: 'section_duplicate', methods: ['GET', 'POST'])]
    public function duplicateAction(Request $request, Section $section)
    {
        /** @var Section $newSection */
        $newSection = clone $section;

        $editable_lang = $request->get('lang',"en");
        $editForm = $this->createForm('App\Form\SectionDuplicateType', $newSection);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($newSection->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($section->getAssetFile(), "uploads/images/home/");
                $asset->setAssetBasePath($imageFileName);
                $newSection->setMainAsset($asset);
            }
            if($newSection->getRemoveAsset()){
                $newSection->setMainAsset(null);
            }

             $this->em->persist($newSection);
             $this->em->flush();
            return $this->redirectToRoute('pages_edit', array('id' => $newSection->getPage()->getPageId(),"lang"=>$editable_lang));
        }

        return $this->render('admin/section/duplicate.html.twig', array(
            'section' => $section,
            'edit_form' => $editForm->createView(),
            'editable_lang' => $editable_lang,
        ));
    }


    #[Route('/{id}/add-asset', name: 'section_add_asset', methods: ['POST'])]
    public function addAssetAction(Request $request, Section $section)
    {
        $assetNew = new Asset();
        $formType = 'App\Form\AssetSectionType';
        if($section->getSectionType()==3){
            // $formType = 'App\Form\AssetSectionProductsType';
        }
        $assetForm = $this->createForm($formType, $assetNew, array(
            'action' => $this->generateUrl('section_add_asset',array("id"=>$section->getSectionId())),
            'method' => 'POST',
        ));
        $assetForm->handleRequest($request);

        if ($assetForm->isSubmitted() && $assetForm->isValid()) {
            $utils = new Utils();

            if($assetNew->getAssetFile()){
                $imageFileName = $utils->upload($assetNew->getAssetFile(), "uploads/images/home/");
                $assetNew->setAssetBasePath($imageFileName);
            }
            $section->addAsset($assetNew);

            $this->em->persist($section);
            $this->em->flush();

            return $this->redirectToRoute('section_edit', array('id' => $section->getSectionId()));
        }



    }


    #[Route('/{lang}/edit/{id}/edit-asset/{section_id}', name: 'section_edit_asset', methods: ['GET', 'POST'])]
    public function editAssetAction(Request $request, Asset $asset, Section $section)
    {

        $editable_lang = $request->get('lang');

        $formType = 'App\Form\AssetSectionType';
        $assetForm = $this->createForm($formType, $asset, array(
            'action' => $this->generateUrl('section_edit_asset',array("id"=>$asset->getAssetId(),"section_id"=>$section->getSectionId(),"lang"=>$editable_lang)),
            'method' => 'POST',
        ));
        $assetForm->handleRequest($request);

        if ($assetForm->isSubmitted() && $assetForm->isValid()) {
            $utils = new Utils();
            if($asset->getAssetFile()){
                $imageFileName = $utils->upload($asset->getAssetFile(), "uploads/images/home/");
                $asset->setAssetBasePath($imageFileName);
            }
            if($asset->removeFile){
                $asset->setAssetBasePath(null);
            }
            $this->em->persist($asset);
            $this->em->flush();
            return $this->redirectToRoute('section_edit_asset',array("id"=>$asset->getAssetId(),"section_id"=>$section->getSectionId(),"lang"=>$editable_lang));
        }

        return $this->render('admin/section/edit-asset.html.twig', array(
            'section' => $section,
            'asset' => $asset,
            'assetForm' => $assetForm->createView(),
            'editable_lang' => $editable_lang,
        ));


    }


    #[Route('/asset/{id}/remove-asset', name: 'section_delete_asset', methods: ['GET'])]
    public function removeAssetAction(Request $request, Asset $asset)
    {

            $this->em->remove($asset);
            $this->em->flush();
            return $this->redirectToRoute('section_edit', array('id' => $request->query->get('section_id')));

    }

    #[Route('/delete/{id}', name: 'section_delete', methods: ['GET'])]
    public function deleteAction(Request $request, Section $section)
    {

        $page_id = $section->getPage()->getPageId();
        $this->em->remove($section);
        $this->em->flush($section);
//        return $this->redirectToRoute('section_index');
        return $this->redirectToRoute('pages_edit',['id'=>$page_id]);
    }

    /**
     * Creates a form to delete a section entity.
     *
     * @param Section $section The section entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Section $section)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('section_delete', array('id' => $section->getSectionId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
