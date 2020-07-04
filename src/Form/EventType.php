<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => '4'
                ]
            ])
            ->add('date_start', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('date_end', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices'  => [
                    'En attente' => '0',
                    'En cours' => '1',
                    'Terminé' => '2',

                ],
            ])

            ->add(
                'photo',
                FileType::class,
                array('data_class' => null, 'required' => true, 'attr' => [
                    'onchange' => 'document.getElementById(\'output\').src = window.URL.createObjectURL(this.files[0])',
                    'accept' => 'image/*',

                ])
            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
