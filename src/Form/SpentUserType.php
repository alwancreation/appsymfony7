<?php

namespace App\Form;

use App\Entity\Spent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpentUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',null,['required'=>true])
            ->add('price',null,['required'=>true])
            ->add('comment',null,['required'=>true])
            ->add('attachedPicture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spent::class,
        ]);
    }
}
