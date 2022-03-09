<?php

namespace App\Form;

use app\Entity\Proprietaire;
use App\Entity\Hebergement;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProprietaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_prop')
            ->add('prenom_prop')
            ->add('email_prop')
            ->add('num_tlf_prop')
            ->add('img_prop', FileType::class,array('data_class'=> null, 'label' => 'Image'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proprietaire::class,
        ]);
    }
}
