<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Annonce2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('date_creation')
            ->add('type_article')
            ->add('matiere')
            ->add('couleur')
            ->add('longueur')
            ->add('largeur')
            ->add('hauteur')
            ->add('etat')
            ->add('histoire')
            ->add('prix_plancher')
            ->add('prix_minimum')
            ->add('prix_moyen')
            ->add('prix_maximum')
            ->add('img1')
            ->add('img2')
            ->add('img3')
            ->add('img4')
            ->add('categorie')
            ->add('collec')
            ->add('feticheUsers')
            ->add('annonceUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
