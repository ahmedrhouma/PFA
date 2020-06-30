<?php

namespace App\Form;

use App\Entity\Candidats;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CandidatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fist_name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('last_name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('gender', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('birthday', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('photo', FileType::class,
                array('data_class' => null,'required' => false,'attr' => [
                    'onchange' => 'document.getElementById(\'output\').src = window.URL.createObjectURL(this.files[0])',
                    'accept' => 'image/*',

                ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidats::class,
        ]);
    }
}
