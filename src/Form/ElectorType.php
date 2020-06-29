<?php

namespace App\Form;

use App\Entity\Elector;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ElectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name',)
            ->add('last_name')
            ->add('email')
            ->add('phone')
            ->add('gender')
            ->add('language')
            ->add('photo', FileType::class, array('data_class' => null,'required' => false))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Elector::class,
        ]);
    }
}
