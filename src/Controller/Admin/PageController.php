<?php

namespace App\Controller\Admin;

use App\Entity\Asset;
use App\Entity\Meta;
use App\Entity\Page;
use App\Entity\Section;
use App\Helper\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pages')]
class PageController extends AbstractController
{
    private $em;
    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'pages_index', methods: ['GET'])]
    public function indexAction()
    {


        $pages = $this->em->getRepository(Page::class)->findAll();

        return $this->render('admin/page/index.html.twig', array(
            'pages' => $pages,
        ));
    }


    #[Route('/new', name: 'pages_new', methods: ['GET', 'POST'])]
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm('App\Form\PageType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($page->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($page->getAssetFile(), "uploads/originals/");
                $asset->setAssetBasePath($imageFileName);
                $page->setAsset($asset);
            }
            $this->em->persist($page);
            $this->em->flush($page);

            return $this->redirectToRoute('pages_index');
        }

        return $this->render('admin/page/new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }


    #[Route('/{id}', name: 'pages_show', methods: ['GET'])]
    public function showAction(Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('admin/page/show.html.twig', array(
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    #[Route('/{id}/edit', name: 'pages_edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, Page $page)
    {
        $editable_lang = $request->get('lang');


        $pageMeta = $page->getMeta();
        if (!$pageMeta){
            $pageMeta = new Meta();
        }
        if ($pageMeta->getMetaId()){
            //$pageMeta->setTranslatableLocale($editable_lang);
            //$this->em->refresh($pageMeta);
        }
        $metaForm = $this->createForm('App\Form\MetaType', $pageMeta);
        $metaForm->handleRequest($request);
        if ($metaForm->isSubmitted() && $metaForm->isValid()) {

            //$pageMeta->setTranslatableLocale($editable_lang);
            $page->setMeta($pageMeta);
            $this->em->persist($page);
            $this->em->flush();
            return $this->redirectToRoute('pages_edit', array('id' => $page->getPageId(),'lang'=>$editable_lang));
        }


        //$page->setTranslatableLocale($editable_lang);
        //$this->em->refresh($page);
        /** @var Section $section */
        foreach ($page->getSections() as $section){
            //$section->setTranslatableLocale($editable_lang);
            //$this->em->refresh($section);
        }
        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('App\Form\PageType', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($page->getAssetFile()){
                $asset = new Asset();
                $utils = new Utils();
                $imageFileName = $utils->upload($page->getAssetFile(), "uploads/originals/");
                $asset->setAssetBasePath($imageFileName);
                $page->setAsset($asset);
            }
            $this->em->flush();

            return $this->redirectToRoute('pages_edit', array('id' => $page->getPageId(),'lang'=>$editable_lang));
        }


        return $this->render('admin/page/edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'editable_lang' => $editable_lang,
            'meta_form' => $metaForm->createView(),
        ));
    }

    #[Route('/{id}', name: 'pages_delete', methods: ['DELETE'])]
    public function deleteAction(Request $request, Page $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->remove($page);
            $this->em->flush($page);
        }

        return $this->redirectToRoute('pages_index');
    }

    /**
     * Creates a form to delete a page entity.
     *
     * @param Page $page The page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pages_delete', array('id' => $page->getPageId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
