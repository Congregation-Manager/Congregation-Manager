<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @psalm-suppress PropertyNotSetInConstructor */
final class EntrypointController extends AbstractController
{
    use RequestPreferredLocaleTrait;

    /**
     * @param string[] $availableLocales
     */
    public function __construct(
        private readonly array $availableLocales,
        private readonly string $defaultLocale,
    ) {
    }

    public function index(Request $request): Response
    {
        $locale = $this->getRightLocaleCodeForVisitor($request);

        return $this->redirectToRoute('congregation_manager_app_homepage', [
            '_locale' => $locale,
        ]);
    }

    private function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }

    /**
     * @return string[]
     */
    private function getAvailableLocales(): array
    {
        return $this->availableLocales;
    }
}
