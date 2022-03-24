<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('pseudo')
            ->add('statut', ChoiceType::class, [
                 'choices' => [
                    'inscrit' => 'UserI',
                    'fétichiste' => 'UserF',
                    'évaluateur' => 'UserE',
                    'dépositaire' => 'UserD'
                ],
                'expanded' => true,
                'multiple' => true
            ], null)
            ->add('prenom')
            ->add('nom')
        ;
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesAsArray) {
                    // transform the array to a string
                    return implode(', ', $rolesAsArray);
                },
                function ($rolesAsString) {
                    // transform the string back to an array
                    return explode(', ', $rolesAsString);
                }
            ))
        ;
        $builder->get('statut')
            ->addModelTransformer(new CallbackTransformer(
                function ($statutAsArray) {
                    // transform the array to a string
                    return explode(', ', $statutAsArray);
                },
                function ($statutAsString) {
                    // transform the string back to an array
                    return implode(', ', $statutAsString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
