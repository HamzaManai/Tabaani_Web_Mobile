<?php

namespace App\Form;

use App\Entity\Hebergement;
use App\Entity\Proprietaire;
use App\Entity\TypeHebergement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class HebergementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_hbrg')
            ->add('adresse_hbrg')
            ->add('nbr_place_hbrg')
            ->add('prix_hbrg')
            ->add('date_hbrg')
            ->add('img_hbrg', FileType::class,array('data_class'=> null, 'label' => 'Image'))
            ->add('type_hbrg', EntityType::class, [
                'class' => TypeHebergement::class,
                'choice_label' => 'nom_type_hbrg',
                'multiple' => false, 
                'placeholder' => 'Choisissez un type de hebergement'
            ])
            ->add('images_hebergement', FileType::class,[
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hebergement::class,
        ]);
    }
}
