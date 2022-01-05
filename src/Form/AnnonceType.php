<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de votre annonce',
                'attr' => [
                    'placeholder' => 'Ex. Jolie lampe ancienne fer forgé'
                ]
            ])
            ->add('date_creation')
            ->add('type_article', TextType::class, [
                'label' => 'Type d\'article',
                'attr' => [
                    'placeholder' => 'Ex. Deco'
                ]
            ])
            ->add('matiere',TextType::class, [
                'label' => 'Matière principale de votre article',
                'attr' => [
                    'placeholder' => 'Ex. Fer forgé'
                ]
            ] )
            ->add('couleur',TextType::class, [
                'label' => 'Couleur et nuance de votre article',
                'attr' => [
                    'placeholder' => 'Ex. Jaune orangé'
                ]
            ] )
            ->add('longueur', IntegerType::class, [
                'label' => 'Longueur principale en cm',
                'attr' => [
                    'placeholder' => 'Ex. 100',
                    'min' => 0
                ]
            ])
            ->add('largeur', IntegerType::class, [
                'label' => 'Largeur ou profondeur en cm',
                'attr' => [
                    'placeholder' => 'Ex. 50',
                    'min' => 0
                ]
            ])
            ->add('hauteur', IntegerType::class, [
                'label' => 'Hauteur ou épaisseur en cm',
                'attr' => [
                    'placeholder' => 'Ex. 80',
                    'min' => 0
                ]
            ])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'parfait' => 'excellent état',
                    'très bon' => 'très bon état',
                    'bon' => 'bon état',
                    'moyen' => 'état moyen'
            ]
            ])
            ->add('histoire', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Ex. Cette lampe à huile ancienne a traversé les époques...'
                ]
            ])
            ->add('prix_plancher')
            ->add('prix_minimum')
            ->add('prix_moyen')
            ->add('prix_maximum')
            ->add('img1', FileType::class, [
                'required' => false,
                'label' => 'Image principale',
                'mapped' => false,
                'help' => 'png, jpg, jpeg ou jp2 - 2 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format PNG, JPG, JPEG ou JP2'
                    ])
                ]
            ])
            ->add('img2', FileType::class, [
                'required' => false,
                'label' => 'Autres images',
                'mapped' => false,
                'help' => 'png, jpg, jpeg ou jp2 - 2 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format PNG, JPG, JPEG ou JP2'
                    ])
                ]
            ])
            ->add('img3', FileType::class, [
                'required' => false,
                'label' => 'Image secondaire',
                'mapped' => false,
                'help' => 'png, jpg, jpeg ou jp2 - 2 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format PNG, JPG, JPEG ou JP2'
                    ])
                ]
            ])
            ->add('img4', FileType::class, [
                'required' => false,
                'label' => 'Image secondaire',
                'mapped' => false,
                'help' => 'png, jpg, jpeg ou jp2 - 2 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format PNG, JPG, JPEG ou JP2'
                    ])
                ]
            ])
            ->add('categorie')
            ->add('collec')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
