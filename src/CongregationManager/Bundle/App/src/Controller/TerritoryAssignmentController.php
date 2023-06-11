<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Controller;

use CongregationManager\Bundle\TerritoryManager\Form\CreateTerritoryAssignmentType;
use CongregationManager\Bundle\TerritoryManager\Form\UpdateTerritoryAssignmentType;
use CongregationManager\Component\TerritoryManager\Application\Command\CreateTerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Application\Command\CreateTerritoryAssignmentHandler;
use CongregationManager\Component\TerritoryManager\Application\Command\UpdateTerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Application\Command\UpdateTerritoryAssignmentHandler;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
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
            $territory = $this->territoryRepository->findOneById($territoryId);
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

        return $this->render('@CongregationManagerApp/territory_assignment/create.html.twig', [
            'form' => $form,
        ]);
    }

    public function update(Request $request, int $id): Response
    {
        $territoryAssignment = $this->territoryAssignmentRepository->findOneById($id);
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

        return $this->render('@CongregationManagerApp/territory_assignment/update.html.twig', [
            'form' => $form,
        ]);
    }
}
