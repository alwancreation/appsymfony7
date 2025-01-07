<?php

namespace App\Form;

use App\Entity\OrderProductLine;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderProductLineNewType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $products = ($options['data'])->products;

        $builder
            ->add('product',EntityType::class,[
                'required'=>true,
                'choices'=>$products,
                'class'=>Product::class,
                'choice_label' => function (Product $product) {
                    return $product->getName().' - (Qtt:'.($product->total_quantity-$product->sale_quantity).') (Pos'.max(0,($product->pos_quantity-$product->sale_quantity)).')';
                }
            ])
            ->add('quantity',null,['required'=>true])
            ->add('price',null,['required'=>true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderProductLine::class,
        ]);
    }
}
