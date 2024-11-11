<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @extends AbstractType<array{email: string}>
 */
final class InviteUserFormType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'congregation_manager_admin.ui.email',
                'translation_domain' => 'admin',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'congregation_manager_admin.ui.invite',
                'translation_domain' => 'admin',
            ])
        ;
    }
}
