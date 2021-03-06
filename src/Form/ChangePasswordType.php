<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'disabled' => true, 
                'label' => 'Mon adresse email'
            ])
            ->add('firstname',TextType::class,[
                'disabled' => true,
                'label' => 'Mon prénom'
            ])
            ->add('lastname',TextType::class,[
                'disabled'=> true,
                'label' => 'Mon nom'
            ])
            ->add('old_password',PasswordType::class,[
                'label' => 'Mon mot de passe actuel',
                'mapped'=> false,
                'attr' => [
                    'placeholder'=>'Veuillez saisir votre mot de passe actuel'
                ]
                ])
                ->add('new_password',RepeatedType::class, [
                    'type'=> PasswordType::class,
                    'mapped'=> false,
                    'invalid_message'=> 'Le mot de passe et la comfirmation doivent être identique.',
                    'label' => 'Mon nouveau mot de passe',
                    'required' => true,
                    'first_options'=>[
                        'label'=>'Mon nouveau mot de passe',
                        'attr'=>['placeholder'=>'Renseignez au moins 1 majuscule, 1 minuscule et 1 chiffre ']
                        ],
                    'second_options' => [
                         'label'=> 'Comfirmez votre nouveau mot de passe' ,
                         'attr'=>['placeholder'=>'Merci de confirmer votre nouveau mot de passe. ']
                        ]
                         ])
                         ->add('submit',SubmitType::class,[
                            'label'=>"Mettre a jour",
                            'attr'=> [
                                'class'=>'btn-block btn-info'
                            ]
                        ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
