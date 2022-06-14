<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Form;

use CongregationManager\Domain\Congregation\Model\Brother;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\Area;
use CongregationManager\Domain\Territory\Model\Territory;
use CongregationManager\Domain\Territory\Model\TerritoryAssignment;
use CongregationManager\Domain\Territory\Model\TerritoryAssignmentInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use DateTimeInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TerritoryAssignmentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('territory', EntityType::class, [
                'class' => Territory::class,
                'label' => 'cm.ui.territory',
                'choice_label' => 'name',
                'placeholder' => 'cm.ui.choose_option',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ])
            ->add('assignmentDate', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('brother', EntityType::class, [
                'class' => Brother::class,
                'label' => 'cm.ui.brother',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'cm.ui.choose_option',
                'required' => false,
            ])
            ->add('revocationDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('save', SubmitType::class)
            ->addEventListener(FormEvents::POST_SET_DATA, [$this, 'onPostSetData'])
        ;
    }

    public function onPostSetData(FormEvent $event): void
    {
        $form = $event->getForm();
        /** @var TerritoryInterface|mixed $territory */
        $territory = $form->getConfig()->getOption('territory');
        if ($territory instanceof TerritoryInterface) {
            $form->get('territory')->setData($territory);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'empty_data' => function (FormInterface $form) {
                /** @var TerritoryInterface $territory */
                $territory = $form->get('territory')->getData();
                /** @var DateTimeInterface $assignmentDate */
                $assignmentDate = $form->get('assignmentDate')->getData();
                /** @var BrotherInterface|null $brother */
                $brother = $form->get('brother')->getData();
                /** @var DateTimeInterface|null $revocationDate */
                $revocationDate = $form->get('revocationDate')->getData();
                return new TerritoryAssignment(
                    $territory,
                    $assignmentDate,
                    $brother,
                    $revocationDate,
                );
            },
            'data_class' => TerritoryAssignment::class,
            'territory' => null
        ]);
    }
}
