<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Form;

use CongregationManager\Bundle\User\Entity\UserInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @extends AbstractType<UserInterface>
 */
class ChangePasswordFormType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['actual_password']) {
            $builder->add('oldPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [new UserPassword()],
                'label' => 'congregation_manager_admin.ui.current_password',
                'translation_domain' => 'admin',
            ]);
        }
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'cm.password.not_blank',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'cm.password.length',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label' => 'congregation_manager_admin.ui.new_password',
                    'translation_domain' => 'admin',
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                    'label' => 'congregation_manager_admin.ui.repeat_password',
                    'translation_domain' => 'admin',
                ],
                'invalid_message' => 'cm.password.must_match',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'actual_password' => false,
        ]);
    }
}
