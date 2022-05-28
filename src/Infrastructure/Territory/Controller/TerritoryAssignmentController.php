<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Controller;

use CongregationManager\Application\Territory\CreateTerritoryAssignment;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Infrastructure\Territory\Form\TerritoryAssignmentFormType;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @psalm-suppress PropertyNotSetInConstructor */
final class TerritoryAssignmentController extends AbstractController
{
    public function __construct(
        private CreateTerritoryAssignment $createTerritoryAssignment,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(Request $request, ?int $territoryId): Response
    {
        $form = $this->createForm(TerritoryAssignmentFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var TerritoryInterface $territory */
            $territory = $form->get('territory')->getData();
            /** @var DateTimeInterface $assignmentDate */
            $assignmentDate = $form->get('assignmentDate')->getData();
            /** @var ?BrotherInterface $brother */
            $brother = $form->get('brother')->getData();
            /** @var ?DateTimeInterface $revocationDate */
            $revocationDate = $form->get('revocationDate')->getData();
            $territoryAssignment = $this->createTerritoryAssignment->create(
                $territory,
                $assignmentDate,
                $brother,
                $revocationDate
            );
            $this->entityManager->flush();

            $this->addFlash('sucess', 'Territory assignment registered');

            return $this->redirectToRoute('app_territory_show', ['id' => $territoryId]);
        }
        return $this->renderForm('app/territory_assignment/create.html.twig', [
            'form' => $form,
        ]);
    }
}
