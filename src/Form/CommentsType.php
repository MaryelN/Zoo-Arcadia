<?php

namespace App\Form;

use App\Document\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Nom',
            ])
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Prénom',
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'E-mail',
                'constraints'=> [
                    new NotBlank([
                        'message' => 'Veuillez saisir un e-mail'
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 50,
                        'minMessage' => 'Veuillez saisir un e-mail valide',
                        'maxMessage' => 'Veuillez saisir un e-mail valide'
                    ])
                    ]
                ])
            ->add('rating', ChoiceType::class, [
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'attr' => ['class' => 'form-control'],
                'label' => 'Note',
                'constraints'=> [
                    new NotBlank([
                        'message' => 'Veuillez saisir une note'
                    ])
                ],
                'placeholder'=> 'Choisir une note' 
                ])
            ->add('comment', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength'=> 5,
                    'maxlength'=> 350  
                ],
                'label' => 'Commentaire',
                'constraints'=> [
                    new NotBlank([
                        'message' => 'Veuillez saisir un commentaire'
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 150,
                        'minMessage' => 'Veuillez saisir un commentaire valide',
                        'maxMessage' => 'Veuillez saisir un commentaire valide'
                    ])
                    ]
                ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary m-3'],
                'label' => 'Envoyer'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
