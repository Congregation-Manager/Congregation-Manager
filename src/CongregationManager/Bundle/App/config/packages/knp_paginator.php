<?php

declare(strict_types=1);

use Symfony\Config\KnpPaginatorConfig;

return static function (KnpPaginatorConfig $knpPaginatorConfig): void {
    $knpPaginatorConfig
        ->pageRange(3)
    ;
    $knpPaginatorConfig
        ->defaultOptions()
            ->pageName('page')
            ->sortFieldName('sort')
            ->sortDirectionName('direction')
            ->distinct(true)
            ->filterFieldName('filterField')
            ->filterValueName('filterValue')
    ;
    $knpPaginatorConfig
        ->template()
            ->pagination('@CongregationManagerApp/components/pagination/pagination.html.twig')
            ->sortable('@KnpPaginator/Pagination/bootstrap_v5_bi_sortable_link.html.twig')
            ->filtration('@KnpPaginator/Pagination/bootstrap_v5_filtration.html.twig')
    ;
};
