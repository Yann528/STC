<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        $builder
        ->add('string',TextType::class,[
            'label'=> false,
            'required'=> false,
            'attr'=>[
                'placeholder'=>'Votre recherche ...',
                
            ]

        ])
        ->add('categories',EntityType::class,[
            'label'=> false,
            'required'=> false,
            'class'=> Category::class,
            'multiple'=>true,
            'expanded'=>true
           ])

        ->add('typeOffre',ChoiceType::class,[
            'required'=> false,
            'choices' => [
                "Location" => "Location",
                "Vente" => "Vente",
            ],
            'attr'=>[
                'class'=>'form-control'
            ]

        ])

        ->add('prixMin',NumberType::class,[
            'label'=> false,
            'required'=> false,
            'attr'=>[
                'placeholder'=>'Prix min -',
                'class' => 'form-control',
                
            ]
        ])

        ->add('prixMax',NumberType::class,[
                'label'=> false,
                'required'=> false,
                'attr'=>[
                    'placeholder'=>'Prix max +',
                    'class' => 'form-control',
                    
                ]

        ])

        ->add('submit', SubmitType::class,[
            'label'=>'Filtrer',
            'attr'=>[
                'class'=>'btn-block btn-info'
            ]

        ])

        ;
        
    }

    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection'=>false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

 

}