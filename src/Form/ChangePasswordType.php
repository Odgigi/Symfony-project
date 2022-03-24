<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon adresse email'
            ])
            ->add('pseudo', TextType::class, [
                'disabled' => true,
                'label' => 'Mon pseudo'
            ])
            ->add('prenom', TextType::class, [
                'disabled' => true,
                'label' => 'Mon prénom'
            ])
            ->add('nom', TextType::class, [
                'disabled' => true,
                'label' => 'Mon nom'
            ])
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'label' => "Mon nouveau mot de passe",
                'required' => true,
                'invalid_message' => "Le mot de passe et sa confirmation doivent être identiques",
                'first_options' => [
                    'label' => 'Mon nouveau mot de passe',
                    'attr' => [
                    'placeholder' => "Veuillez saisir votre nouveau mot de passe",
                    'autocomplete' => 'new-password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "Confirmez votre nouveau mot de passe"
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Mettre à jour'
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
