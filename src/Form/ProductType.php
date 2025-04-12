<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false, // Disable HTML5 validation for this field
            ])
            ->add('price', NumberType::class, [
                'required' => false, // Disable HTML5 validation for this field
            ])
            ->add('datefabrication', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'input'  => 'string',
                'format' => 'yyyy-MM-dd',
                'attr'   => [
                    'min' => '2000-01-01',
                    'max' => '3000-01-01',
                ],
                'required' => false, // Disable HTML5 validation for this field
            ])
            ->add('quantite', NumberType::class, [
                'required' => false, // Disable HTML5 validation for this field
            ])
            ->add('likes', NumberType::class, [
                'required' => false, // Disable HTML5 validation for this field
            ])
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'required' => false, // Disable HTML5 validation for this field
            ])
            ->add('Category', ChoiceType::class, [
                'choices'  => [
                    'MOBILE PRODUCTS' => 'MOBILE PRODUCTS',
                    'SMART WATCHES' => 'SMART WATCHES',
                ],
                'placeholder' => 'Select a category',
                'required' => false, // Disable HTML5 validation for this field
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
