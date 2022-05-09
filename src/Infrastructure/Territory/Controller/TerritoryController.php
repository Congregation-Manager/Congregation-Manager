<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Controller;

use CongregationManager\Domain\Territory\Repository\AreaRepositoryInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryRepositoryInterface;
use CongregationManager\Infrastructure\Territory\Repository\Filter\QueryBuilderTerritoryRepositoryFilter;
use Knp\Component\Pager\Event\Subscriber\Paginate\Callback\CallbackPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class TerritoryController extends AbstractController
{
    public function __construct(
        private TerritoryRepositoryInterface $territoryRepository,
        private PaginatorInterface $paginator,
        private AreaRepositoryInterface $areaRepository
    ) {
    }

    public function index(Request $request): Response
    {
        $filters = new QueryBuilderTerritoryRepositoryFilter();
        $filters->byArea($this->areaRepository->find($request->query->getInt('area')));
        $sort = $request->query->get('sort', 't.name');
        $direction = $request->query->getAlpha('direction', 'ASC');
        $query = $this->territoryRepository->filter($filters);

        $count = static function () use ($query) {
            return $query->getTotalCount();
        };
        $items = static function ($offset, $limit) use ($query, $sort, $direction) {
            return $query->getResults($limit, $offset, $sort, $direction);
        };
        $target = new CallbackPagination($count, $items);
        $pagination = $this->paginator->paginate(
            $target,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('app/territory/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
