<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @psalm-suppress PropertyNotSetInConstructor */
final class HomePageController extends AbstractController
{
    /**
     * @param string[] $availableLocales
     */
    public function __construct(
        private readonly array $availableLocales,
    ) {
    }

    public function index(Request $request): Response
    {
        return $this->render('@CongregationManagerApp/homepage/index.html.twig', [
            'locales' => $this->availableLocales,
            'active' => $request->getLocale(),
        ]);
    }
}
