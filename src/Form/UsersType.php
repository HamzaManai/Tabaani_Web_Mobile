<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a first name',
                    ])
                ],
            ])
            ->add('LastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a last name',
                    ])
                ],
            ])

            ->add('Birthday', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your birthday',
                    ]),
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('Number', NumberType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your number',
                    ]), new Length([
                        'max' => 8,
                        'minMessage' => 'Your number should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 8,
                    ])
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add(
                'username',
                TextType::class,
                [
                    "attr" => [
                        "class" => "form-control"
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter your username',
                        ])
                    ]
                ]
            )
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your email',
                    ]),
                    new Email([
                        'message' => 'Please enter a valid email',
                    ])
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
