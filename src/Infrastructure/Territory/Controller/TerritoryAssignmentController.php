<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Controller;

use CongregationManager\Application\Territory\CreateTerritoryAssignment;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryAssignmentInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryRepositoryInterface;
use CongregationManager\Infrastructure\Territory\Form\TerritoryAssignmentFormType;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

/** @psalm-suppress PropertyNotSetInConstructor */
final class TerritoryAssignmentController extends AbstractController
{
    public function __construct(
        private TerritoryRepositoryInterface $territoryRepository,
        private TerritoryAssignmentRepositoryInterface $territoryAssignmentRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(Request $request): Response
    {
        $territory = null;
        if (($territoryId = $request->query->getInt('territoryId')) !== 0) {
            $territory = $this->territoryRepository->find($territoryId);
        }
        $form = $this->createForm(TerritoryAssignmentFormType::class, null, [
            'territory' => $territory,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $territoryAssignment = $form->getData();
            Assert::isInstanceOf($territoryAssignment, TerritoryAssignmentInterface::class);
            $this->territoryAssignmentRepository->add($territoryAssignment);
            $this->entityManager->flush();

            $this->addFlash('sucess', 'Territory assignment created');

            return $this->redirectToRoute('app_territory_show', ['id' => $territoryId]);
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
        $form = $this->createForm(TerritoryAssignmentFormType::class, $territoryAssignment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('sucess', 'Territory assignment updated');

            return $this->redirectToRoute('app_territory_show', ['id' => $territoryAssignment->getTerritory()->getId()]);
        }
        return $this->renderForm('app/territory_assignment/update.html.twig', [
            'form' => $form,
        ]);
    }
}
