<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => "Votre prénom",
                'attr' => [
                    'placeholder' => "Merci de saisir votre prénom"
                ]
            ])    
            ->add('nom', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => "Merci de saisir votre nom"
                ]
            ])
            ->add('pseudo',  TextType::class,  [
                'label' => "Votre pseudo",
                'attr' => [
                    'placeholder' => "Veuillez choisir un pseudo"
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire: le pseudo servira à vous identifier sur le site.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre pseudo doit comporter au moins {{ limit }} caractères',
                        'max' => 30,
                        'minMessage' => 'Votre pseudo ne doit pas comporter plus de {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "Votre email",
                'attr' => [
                    'placeholder' => "Veuillez saisir votre adresse email"
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => "Votre mot de passe",
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                    'placeholder' => "Veuillez saisir votre mot de passe",
                    'autocomplete' => 'new-password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe',
                    'attr' => [
                        'placeholder' => "Confirmez votre mot de passe"
                    ]
                ],
                'invalid_message' => "Le mot de passe et sa confirmation doivent être identiques",
                'mapped' => false, // instead of being set onto the object directly, this is read and encoded in the controller
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ]
            ])
            // ->add('confirmPassword', PasswordType::class, [
            //     'mapped' => false,
            //     'label' => "Confirmation du mot de passe",
            //     'attr' => [
            //         'placeholder' => "Veuillez confirmer votre mot de passe"
            //     ]
            // ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les termes et conditions.',
                    ])
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
