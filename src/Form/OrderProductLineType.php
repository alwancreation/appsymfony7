<?php

namespace App\Form;

use App\Entity\OrderProductLine;
use App\Entity\ProductCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderProductLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('supplier',null,['required'=>true])
            ->add('quantity',null,['required'=>true])
            ->add('price',null,['required'=>true])
            ->add('storeHouse',null,['required'=>true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderProductLine::class,
        ]);
    }
}
