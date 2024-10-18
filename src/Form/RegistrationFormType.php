<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastname')
        ->add('name')
        ->add('email')
        
        // Add roles as a multiple-choice field
        ->add('roles', ChoiceType::class, [
            'choices'  => [
                'Employé' => 'ROLE_USER',           // label => value
                'Vétérinaire' => 'ROLE_VETERINARY', // label => value
            ],
            'expanded' => true,  
            'label'    => 'Rôle',
            'mapped'   => false, 
            'constraints' => [
                new Choice([
                    'choices' => ['ROLE_USER', 'ROLE_VETERINARY'],
                    'message' => 'Veuillez choisir un rôle valide.',
                ]),
            ],
        ])

        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'label' => 'Conditions d\'utilisation',  
            'constraints' => [
                new IsTrue([
                    'message' => 'Vous devez accepter nos conditions d\'utilisation.',
                ]),
            ],
        ])
        ->add('plainPassword', PasswordType::class, [
                            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veulliez entrer un mot de passe',
                ]),
                new Length([
                    'min' => 16,
                    'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
