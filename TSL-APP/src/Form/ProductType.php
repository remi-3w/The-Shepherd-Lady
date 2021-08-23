<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\DataTransformer\MoneyTranformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class,[
                'label'=> 'Nom du produit',
                'attr' => [' placeholder '=>'ex: Trousse à projet']
            ])
            ->add( 'Description', TextareaType::class, [
            'label' => 'Description du produit',
            'attr' => [' placeholder ' => 'Description du produit']
        ])
            ->add( 'Stock', NumberType::class, [
            'label' => 'Quantité du produit',
            'attr' => [' placeholder ' => 'ex: 10']
        ])
            ->add('Picture', UrlType::class,[
                'label'=> 'Url de l\'image',
                'attr' => [' placeholder '=>'https://picsum/200']
            ])
            ->add('Price', MoneyType::class,[
                'label'=> 'Prix du produit',
                'attr' => [' placeholder '=>'ex: 200000 pour 200€'],
                'divisor' => 100
            ])         
            ->add('Category', EntityType::class, [               
                'label' => 'Catégorie du produit.',
                'multiple' => true,
                'expanded' => true,               
                'class' => Category::class,
                'required' => true,              
                'choice_label' => function(Category $category){
                    return($category->getName());                   
                }
               
            ]);
               

                


            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
