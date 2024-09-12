<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nom',
            'required' => true,
            'constraints' => [
                new Assert\NotBlank(['message' => 'Le nom est obligatoire.']),
            ],
            'label_attr' => [
                'class' => ' text-white'
            ]
        ])
        ->add('company', TextType::class, [
            'label' => 'Entreprise',
            'required' => false,
            'attr' => [
                'class' => 'form-control'
            ],
            'label_attr' => [
                'class' => ' text-white'
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'required' => true,
            'constraints' => [
                new Assert\NotBlank(['message' => 'L\'email est obligatoire.']),
                new Assert\Email(['message' => 'L\'email n\'est pas valide.']),
            ],
            'attr' => [
                'class' => 'form-control'
            ],
            'label_attr' => [
                'class' => ' text-white'
            ]
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Message',
            'required' => true,
            'constraints' => [
                new Assert\NotBlank(['message' => 'Le message est obligatoire.']),
            ],
            'attr' => [
                'class' => 'form-control'
            ],
            'label_attr' => [
                'class' => ' text-white'
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => [
                'class' => 'btn btn-secondary'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
