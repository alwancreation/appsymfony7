<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pageUrl')
            ->add('pageName')
            ->add('pageTitle',null,["required" => false])
            ->add('pageSubTitle',null,["required" => false])
            ->add('pageShortDescription',TextareaType::class,array(
                "required" => false,
                "attr"=>array(
                    "class"=>"ckeditor",
                    "style"=>"height:120px",
                )))
            ->add('pageLongDescription',TextareaType::class,array(
                "required" => false,
                "attr"=>array(
                    "class"=>"ckeditor",
                    "style"=>"height:300px",
                )))
            ->add('asset_file',FileType::class,array("required"=>false))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Page'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontbundle_page';
    }


}
