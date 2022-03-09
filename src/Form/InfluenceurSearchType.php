<?php

namespace App\Form;

use App\Entity\InfluenceurSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfluenceurSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom')
        ->add('code')
        ->add('facebookPage')
        ->add('instagramPage')
        ->add('email')
             ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfluenceurSearch::class,
            'method' =>'get',
            'csrf protection' =>false
        ]);
    }
 
}
