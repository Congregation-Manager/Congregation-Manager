<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Form;

use CongregationManager\Component\Congregation\Domain\Brother;
use CongregationManager\Component\TerritoryManager\Application\Command\UpdateTerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\Territory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<UpdateTerritoryAssignment>
 */
final class UpdateTerritoryAssignmentType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('territory', EntityType::class, [
                'class' => Territory::class,
                'label' => 'congregation_manager_territory_manager.ui.territory',
                'choice_label' => 'number',
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
            ->add('update', SubmitType::class)
        ;
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateTerritoryAssignment::class,
        ]);
    }
}
