<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre nom',
                'attr'=>[
                    'placeholder' => 'Votre nom *'
                ]
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email',
                'attr'=>[
                    'placeholder' => 'Votre email'
                ]
            ])
            ->add('subject', TextType::class,[
                'label' => 'Sujet',
                'attr'=>[
                    'placeholder' => 'Votre préocupation'
                    ]
            ])
            ->add('message', TextareaType::class,[
                'label' => 'Message',
                'attr'=>[
                    'placeholder' => 'Entrez votre message',
                    'cols' => '30',
                    'rows' => '7',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class
        ]);
    }
}
