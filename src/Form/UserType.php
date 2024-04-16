<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('email', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('phonenum', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => User::GENDER_MALE,
                    'Female' => User::GENDER_MALE,
                    
                ]])
            ->add('adresse', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('age', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('password', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('height', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('weight', null, [
                'attr' => ['class' => 'form-control']
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
