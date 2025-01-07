<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetSectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assetTitle',null,array("required"=>true))
            ->add('assetLinkTitle',null,array("required"=>false))
            ->add('assetDescription',null,array(
                "attr"=>array(
                    "class"=>"ckeditor",
                    "style"=>"height:200px",
                )))
            ->add('assetLink',null,array("required"=>false))
            ->add('assetOrder')
            ->add('assetFile',null,array("required"=>false))
            ->add('removeFile',CheckboxType::class,['required'=>false])
            ->add('assetIcon')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Asset'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontbundle_section_asset';
    }


}
