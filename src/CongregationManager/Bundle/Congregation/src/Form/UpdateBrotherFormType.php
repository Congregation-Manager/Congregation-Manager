<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Congregation\Form;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UpdateBrotherFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => true,
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
            ])
            ->add('middleName', TextType::class, [
                'required' => false,
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('baptismDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BrotherInterface::class,
        ]);
    }
}
