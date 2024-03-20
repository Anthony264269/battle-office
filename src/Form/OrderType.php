<?php

namespace App\Form;

use App\Entity\country;
use App\Entity\MethodPayement;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Shipping;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('adress')
            ->add('additionnalAdress')
            ->add('zipCode')
            ->add('phone')
            ->add('email')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            // ->add('updatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('deletedAt', null, [
            //     'widget' => 'single_text',
            // ])
            ->add('city')
            ->add('country', EntityType::class, [
                'class' => country::class,
                'choice_label' => 'name',
            ])
        //     ->add('product', EntityType::class, [
        //         'class' => Product::class,
        //         'choice_label' => 'id',
        //     ])
        //     ->add('methodPayement', EntityType::class, [
        //         'class' => MethodPayement::class,
        //         'choice_label' => 'id',
        //     ])
           ->add('shipping', ShippingType::class)
         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'allow_extra_fields' => true,
        ]);
    }
}
