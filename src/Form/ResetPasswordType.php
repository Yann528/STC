<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('new_password',RepeatedType::class, [
            'type'=> PasswordType::class,
            'mapped'=> false,
            'invalid_message'=> 'Le mot de passe et la comfirmation doivent être identique.',
            'label' => 'Mon nouveau mot de passe',
            'required' => true,
            'first_options'=>[
                'label'=>'Mon nouveau mot de passe',
                'attr'=>['placeholder'=>'Minimum 6 caractères, 1 majuscule, 1 minuscule et 1 chiffre.']
                ],
            'second_options' => [
                 'label'=> 'comfirmez votre nouveau mot de passe' ,
                 'attr'=>['placeholder'=>'Merci de confirmer votre nouveau mot de passe. ']
                ]
                 ])
                 ->add('submit',SubmitType::class,[
                    'label'=>"Mettre a jour mon mot de passe.",
                    'attr'=> [
                        'class'=>'btn-block btn-info'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
