<?php

namespace App\Form;

use App\Entity\Elector;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ElectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cin', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '8',
                    'maxlength' => '8'
                ]
            ])
            ->add('first_name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('last_name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('phone', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '8',
                    'maxlength' => '8'

                ]
            ])
            ->add('gender', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices'  => [
                    'Homme' => '0',
                    'Femme' => '1',
                ],
            ])
            ->add('birth', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add(
                'photo',
                FileType::class,
                array('data_class' => null, 'required' => false, 'attr' => [
                    'onchange' => 'document.getElementById(\'output\').src = window.URL.createObjectURL(this.files[0])',
                    'accept' => 'image/*',

                ])
            )
            ->add('event', EntityType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'exampleFormControlSelect1',
                ],
                // looks for choices from this entity
                'class' => Event::class,
                'multiple' => true,
                'translation_domain' => 'Default',
                'required' => false

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Elector::class,
        ]);
    }
}
