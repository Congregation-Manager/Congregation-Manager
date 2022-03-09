<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Form;

use CongregationManager\Infrastructure\Common\Model\ProfileUpdate;
use CongregationManager\Infrastructure\Congregation\Form\UpdateBrotherFormType;
use CongregationManager\Infrastructure\User\Form\ChangeEmailFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProfileUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brother', UpdateBrotherFormType::class)
            ->add('appUser', ChangeEmailFormType::class, ['with_submit' => false])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProfileUpdate::class,
        ]);
    }
}
