<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Form;

use CongregationManager\Component\Core\Domain\Context\CongregationContextInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AreaFormType extends EntityType
{
    public function __construct(
        private CongregationContextInterface $congregationContext,
        ManagerRegistry $registry
    ) {
        parent::__construct($registry);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('query_builder', function (EntityRepository $er) {
            $qb = $er->createQueryBuilder('a');

            try {
                $congregation = $this->congregationContext->getCongregation();
            } catch (RuntimeException) {
                $congregation = null;
            }
            if ($congregation !== null) {
                $qb->where($qb->expr()->eq('a.congregation', $congregation->getId()));
            }
            $qb->orderBy('a.name', 'ASC');

            return $qb;
        });
    }
}
