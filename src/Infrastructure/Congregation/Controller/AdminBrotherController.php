<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Congregation\Controller;

use CongregationManager\Domain\Congregation\Repository\BrotherRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AdminBrotherController extends AbstractController
{
    public function __construct(
        private BrotherRepositoryInterface $brotherRepository
    ) {
    }

    public function index(Request $request): Response
    {
        $brothers = $this->brotherRepository->findAll();
        return $this->render('admin/brother/index.html.twig', [
            'brothers' => $brothers,
        ]);
    }

    public function show(Request $request, int $id): Response
    {
        $brother = $this->brotherRepository->find($id);
        if ($brother === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('admin/brother/show.html.twig', [
            'brother' => $brother,
        ]);
    }
}
