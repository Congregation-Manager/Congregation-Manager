<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Form;

use CongregationManager\Domain\Congregation\Model\Brother;
use CongregationManager\Domain\Territory\Model\Area;
use CongregationManager\Infrastructure\Territory\Repository\Filter\QueryBuilderTerritoryRepositoryFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TerritoryFiltersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('areas', EntityType::class, [
                'class' => Area::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('notAssigned', ChoiceType::class, [
                'choices'  => [
                    'All' => null,
                    'Not assigned' => true,
                    'Assigned' => false,
                ],
                'label' => 'Status',
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('assignedTo', EntityType::class, [
                'class' => Brother::class,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QueryBuilderTerritoryRepositoryFilter::class
        ]);
    }
}
