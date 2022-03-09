<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Hebergement;
use App\Entity\proprietaire;
use App\Entity\TypeHebergement;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => 'search by name',
                'required' => false,
                'attr' => [
                    'placeholder' => 'name of the hebergement'
                ]
            ])

            ->add('proprietaire', EntityType::class, [
                'label' => 'Owner',
                'required' => false,
                'class' => Proprietaire::class,
                'placeholder' => "----------------------",
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('type_hbrg', EntityType::class, [
                'label' => 'Accommodation type',
                'required' => false,
                'class' => TypeHebergement::class,
                'placeholder' => "----------------------",
                'expanded' => false,
                'multiple' => false,
            ])

            ->add('nbr_place', NumberType::class, [
                'label' => 'Number of places available',
                'required' => false,
                'attr' => [
                    'placeholder' => 'number'
                ]
            ])
            ->add('adresse_hbrg', TextType::class, [
                'label' => 'Address of Accomadation',
                'required' => false,
                'attr' => [
                    'placeholder' => 'address'
                ]
            ])
            ->add('min', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix min',
                    'type' => 'number'
                ]
            ])
            ->add('max', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix max',
                    'type' => 'number'
                ]
            ])
            ->add('date_hbrg', DateTimeType::class, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'format' => 'yyyy-MM-dd',

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
