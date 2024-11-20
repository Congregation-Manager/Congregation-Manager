<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Form;

use CongregationManager\Bundle\User\Entity\UIUserInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<UIUserInterface>
 */
final class ChangeEmailFormType extends AbstractType
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
        ;
        if ($options['with_submit']) {
            $builder->add('submit', SubmitType::class, [
                'label' => 'congregation_manager_admin.ui.save',
                'translation_domain' => 'admin',
            ]);
        }
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UIUserInterface::class,
            'with_submit' => true,
        ]);
    }
}
