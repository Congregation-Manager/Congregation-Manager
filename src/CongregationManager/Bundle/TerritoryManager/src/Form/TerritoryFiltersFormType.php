<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Form;

use CongregationManager\Bundle\TerritoryManager\Repository\Filter\QueryBuilderTerritoryRepositoryFilter;
use CongregationManager\Component\Core\Domain\Area;
use CongregationManager\Component\Core\Domain\Brother;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<QueryBuilderTerritoryRepositoryFilter>
 */
final class TerritoryFiltersFormType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('areas', AreaFormType::class, [
                'class' => Area::class,
                'label' => 'congregation_manager_territory_manager.ui.area',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('notAssigned', ChoiceType::class, [
                'choices' => [
                    'congregation_manager_territory_manager.ui.any' => null,
                    'congregation_manager_territory_manager.ui.not_assigned' => true,
                    'congregation_manager_territory_manager.ui.assigned' => false,
                ],
                'label' => 'congregation_manager_territory_manager.ui.status',
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('assignedTo', EntityType::class, [
                'class' => Brother::class,
                'label' => 'congregation_manager_territory_manager.ui.assigned_to',
                'placeholder' => 'congregation_manager_territory_manager.ui.choose_option',
                'required' => false,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('filter', SubmitType::class, [
                'label' => 'congregation_manager_territory_manager.ui.filter',
            ])
        ;
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QueryBuilderTerritoryRepositoryFilter::class,
        ]);
    }
}
