<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Form;

use CongregationManager\Bundle\Congregation\Form\UpdateBrotherFormType;
use CongregationManager\Bundle\Core\Model\ProfileUpdate;
use CongregationManager\Bundle\User\Form\ChangeEmailFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<ProfileUpdate>
 */
final class ProfileUpdateFormType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brother', UpdateBrotherFormType::class)
            ->add('appUser', ChangeEmailFormType::class, [
                'with_submit' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProfileUpdate::class,
        ]);
    }
}
