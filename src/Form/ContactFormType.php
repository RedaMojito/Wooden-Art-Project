<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,
             ['label'=> false, 'attr' => ['class' => 'form-control contact-fields', 'placeholder' => 'Votre Prénom *']])
            ->add('lastname', TextType::class,
             ['label'=> false, 'attr' => ['class' => 'form-control contact-fields', 'placeholder' => 'Votre Nom *']])
            ->add('phonenumber', TelType::class,
             ['label'=> false, 'attr' => ['class' => 'form-control contact-fields', 'placeholder' => 'Votre Numero *']])
            ->add('email', EmailType::class,
             ['label'=> false, 'attr' => ['class' => 'form-control contact-fields', 'placeholder' => 'Votre Email *']])
            ->add('message', TextareaType::class,
             ['label'=> false, 'attr' => ['class' => 'form-control contact-message', 'placeholder' => 'Envoyer Message *']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
