<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Controller;

use CongregationManager\Domain\Territory\Repository\TerritoryRepositoryInterface;
use CongregationManager\Infrastructure\Territory\Form\TerritoryFiltersFormType;
use CongregationManager\Infrastructure\Territory\Repository\Filter\QueryBuilderTerritoryRepositoryFilter;
use Knp\Component\Pager\Event\Subscriber\Paginate\Callback\CallbackPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/** @psalm-suppress PropertyNotSetInConstructor */
final class TerritoryController extends AbstractController
{
    public function __construct(
        private TerritoryRepositoryInterface $territoryRepository,
        private PaginatorInterface $paginator
    ) {
    }

    public function index(Request $request): Response
    {
        $filters = new QueryBuilderTerritoryRepositoryFilter();
        $form = $this->createForm(TerritoryFiltersFormType::class, $filters, [
            'method' => 'GET',
        ]);
        $sort = (string) $request->query->get('sort', 't.name');
        $direction = $request->query->getAlpha('direction', 'ASC');
        $form->handleRequest($request);
        $query = $this->territoryRepository->filter($filters);

        $count = static function () use ($query): int {
            return $query->getTotalCount();
        };
        $items = static function (int $offset, int $limit) use ($query, $sort, $direction): array {
            return $query->getResults($limit, $offset, $sort, $direction);
        };
        $pagination = $this->paginator->paginate(
            new CallbackPagination($count, $items),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10),
            [
                'align' => 'center',
                'size' => 'medium',
            ]
        );

        return $this->renderForm('app/territory/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form
        ]);
    }

    public function show(int $id, Request $request): Response
    {
        $territory = $this->territoryRepository->find($id);
        if ($territory === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('app/territory/show.html.twig', [
            'territory' => $territory,
        ]);
    }
}
