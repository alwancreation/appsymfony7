<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sectionTitle')
            ->add('sectionSubTitle')
            ->add('sectionDescription',TextareaType::class,array(
                "required" => false,
                "attr"=>array(
                    "class"=>"ckeditor",
                    "style"=>"height:400px",
                )))
            // ->add('products')
            ->add('sectionOrder')
            ->add('sectionLink',null,array("required"=>false))
            ->add('sectionLinkTitle',null,array("required"=>false))

            ->add('sectionType',ChoiceType::class,array(
                'choices'  => array(
                    'Content center' => 1,
                    'Image' => 33,
                    'Simple content' => 32,
                    'Content' => 2,
                    'Our Services' => 3,
                    'Client Testimonials' => 4,
                    'Our Team' => 5,
                    'Image & Content (left)' => 6,
                    'Image & Content (right)' => 7,
                    'Gallery' => 8,
                    'Content Image (left)' => 9,
                    'Content Image (right)' => 11,
                    'Flex Slider' => 10,
                    'Video' => 12,
                    'Protfolio' => 13,
                    'Why choose use' => 15,
                    'Full slick images' => 16,
                    'Element list' => 30,
                    'GRID 3 element img/title' => 31,
                ),
            ))
            ->add('assetFile')
            ->add('removeAsset',CheckboxType::class,array("required"=>false))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Section'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_section';
    }


}
