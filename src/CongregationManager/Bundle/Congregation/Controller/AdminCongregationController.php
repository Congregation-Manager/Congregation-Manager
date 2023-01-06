<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Congregation\Controller;

use CongregationManager\Component\Congregation\Domain\Repository\CongregationRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AdminCongregationController extends AbstractController
{
    public function __construct(
        private CongregationRepositoryInterface $congregationRepository
    ) {
    }

    public function index(Request $request): Response
    {
        $congregations = $this->congregationRepository->findAll();

        return $this->render('admin/congregation/index.html.twig', [
            'congregations' => $congregations,
        ]);
    }

    public function show(Request $request, int $id): Response
    {
        $congregation = $this->congregationRepository->find($id);
        if ($congregation === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('admin/congregation/show.html.twig', [
            'congregation' => $congregation,
        ]);
    }
}
