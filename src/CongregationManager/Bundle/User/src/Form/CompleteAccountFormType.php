<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Form;

use CongregationManager\Bundle\Congregation\Form\UpdateBrotherFormType;
use CongregationManager\Bundle\User\Entity\CompleteAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @extends AbstractType<CompleteAccount>
 */
final class CompleteAccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brother', UpdateBrotherFormType::class)
            ->add('email', EmailType::class, [
                'required' => true,
            ])
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
                    'label' => 'cm.label.new_password',
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                    'label' => 'cm.label.repeat_password',
                ],
                'invalid_message' => 'cm.password.must_match',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => true,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompleteAccount::class,
        ]);
    }
}
