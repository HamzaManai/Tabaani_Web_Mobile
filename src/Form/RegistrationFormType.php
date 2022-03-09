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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstname',
                TextType::class,
                [
                    "attr" => [
                        "class" => "form-control"
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter your first name',
                        ])
                    ]
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    "attr" => [
                        "class" => "form-control"
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter your last name',
                        ])
                    ]
                ]
            )
            ->add("type", ChoiceType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                'mapped' => false,
                "placeholder" => "Choose your type",
                'choices' => [
                    "Normal User" => "Normal User",
                    "Influencer" => "Influencer"
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your type',
                    ])
                ]
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
            ->add('image', FileType::class, [
                'label' => 'Profile Image',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please upload your image',
                    ]),
                ],
                "attr" => [
                    "class" => "form-control"
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
            ])
            ->add('password', PasswordType::class,  [
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
