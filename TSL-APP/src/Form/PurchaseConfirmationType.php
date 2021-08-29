<?php

namespace App\Form;

use App\Entity\Purchase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PurchaseConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName',TextType::class, [
                'label'=>'Nom et prénom' ,
                'attr' => ['placeholder' =>'ex: Marie Dupont']
            ])
            ->add('adress',TextType::class, [
                'label'=>'adresse de livraison',
                'attr' => ['placeholder' =>'ex: 10 rue des saisons'] 
            ])
            ->add('zipCode',TextType::class, [
                'label'=>'code postale de livraison' ,
                'attr' => ['placeholder' =>'ex: 75001']
            ])
            ->add('city',TextType::class, [
                'label'=>'ville de livraison' ,
                'attr' => ['placeholder' =>'ex: Paris']
            ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class,
        ]);
    }
}
