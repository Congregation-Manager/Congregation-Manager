<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Controller;

use CongregationManager\Application\Territory\Command\CreateTerritoryAssignment;
use CongregationManager\Application\Territory\Command\CreateTerritoryAssignmentHandler;
use CongregationManager\Application\Territory\Command\UpdateTerritoryAssignment;
use CongregationManager\Application\Territory\Command\UpdateTerritoryAssignmentHandler;
use CongregationManager\Domain\Territory\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryRepositoryInterface;
use CongregationManager\Infrastructure\Territory\Form\CreateTerritoryAssignmentType;
use CongregationManager\Infrastructure\Territory\Form\UpdateTerritoryAssignmentType;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @psalm-suppress PropertyNotSetInConstructor */
final class TerritoryAssignmentController extends AbstractController
{
    public function __construct(
        private readonly TerritoryRepositoryInterface $territoryRepository,
        private readonly TerritoryAssignmentRepositoryInterface $territoryAssignmentRepository,
        private readonly CreateTerritoryAssignmentHandler $createTerritoryAssignmentHandler,
        private readonly UpdateTerritoryAssignmentHandler $updateTerritoryAssignmentHandler,
    ) {
    }

    public function create(Request $request): Response
    {
        $territory = null;
        $territoryId = $request->query->getInt('territoryId');
        if ($territoryId !== 0) {
            $territory = $this->territoryRepository->find($territoryId);
        }
        $command = new CreateTerritoryAssignment($territory, new DateTimeImmutable());
        $form = $this->createForm(CreateTerritoryAssignmentType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->createTerritoryAssignmentHandler->__invoke($command);

            $this->addFlash('success', 'Territory assignment created');

            return $this->redirectToRoute('app_territory_show', [
                'id' => $territoryId,
            ]);
        }

        return $this->renderForm('app/territory_assignment/create.html.twig', [
            'form' => $form,
        ]);
    }

    public function update(Request $request, int $id): Response
    {
        $territoryAssignment = $this->territoryAssignmentRepository->find($id);
        if ($territoryAssignment === null) {
            throw $this->createNotFoundException();
        }
        $command = UpdateTerritoryAssignment::createFromTerritoryAssignment($territoryAssignment);
        $form = $this->createForm(UpdateTerritoryAssignmentType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateTerritoryAssignmentHandler->__invoke($command);

            $this->addFlash('success', 'Territory assignment updated');

            return $this->redirectToRoute('app_territory_show', [
                'id' => $territoryAssignment->getTerritory()
                    ->getId(),
            ]);
        }

        return $this->renderForm('app/territory_assignment/update.html.twig', [
            'form' => $form,
        ]);
    }
}
