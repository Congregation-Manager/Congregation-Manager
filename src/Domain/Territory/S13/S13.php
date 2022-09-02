<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\S13;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class S13
{
    /**
     * @var Collection<array-key, Page>
     */
    private Collection $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    /**
     * @return Collection<array-key, Page>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    /**
     * @param Collection<array-key, Page> $pages
     */
    public function setPages(Collection $pages): void
    {
        $this->pages = $pages;
    }

    public function addPage(Page $page): void
    {
        if ($this->pages->contains($page)) {
            return;
        }

        $this->pages->add($page);
    }

    public function removePage(Page $page): void
    {
        if (! $this->pages->contains($page)) {
            return;
        }

        $this->pages->removeElement($page);
    }
}
