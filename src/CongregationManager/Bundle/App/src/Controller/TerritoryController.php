<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Controller;

use CongregationManager\Bundle\TerritoryManager\Form\TerritoryFiltersFormType;
use CongregationManager\Bundle\TerritoryManager\Repository\Filter\QueryBuilderTerritoryRepositoryFilter;
use CongregationManager\Component\Core\Domain\Context\CongregationContextInterface;
use CongregationManager\Component\TerritoryManager\Domain\Generator\S13GeneratorInterface;
use CongregationManager\Component\TerritoryManager\Domain\Renderer\S13RendererInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
use DateTimeImmutable;
use Knp\Component\Pager\Event\Subscriber\Paginate\Callback\CallbackPagination;
use Knp\Component\Pager\PaginatorInterface;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webmozart\Assert\Assert;

/** @psalm-suppress PropertyNotSetInConstructor */
final class TerritoryController extends AbstractController
{
    public function __construct(
        private readonly TerritoryRepositoryInterface $territoryRepository,
        private readonly PaginatorInterface $paginator,
        private readonly S13GeneratorInterface $s13Generator,
        private readonly CongregationContextInterface $congregationContext,
        private readonly S13RendererInterface $s13Renderer,
    ) {
    }

    public function index(Request $request): Response
    {
        $filters = new QueryBuilderTerritoryRepositoryFilter();
        $form = $this->createForm(TerritoryFiltersFormType::class, $filters, [
            'method' => 'GET',
        ]);
        $sort = $request->query->get('sort', 't.number');
        $direction = $request->query->getAlpha('direction', 'ASC');
        $form->handleRequest($request);
        $query = $this->territoryRepository->filter($filters);

        $count = static function () use ($query): int {
            return $query->getTotalCount();
        };
        $items = static function (int $offset, int $limit) use ($query, $sort, $direction): array {
            return $query->getResults($limit, $offset, $sort, $direction);
        };
        $pagination = $this->paginator->paginate(
            new CallbackPagination($count, $items),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10),
            [
                'align' => 'center',
                'size' => 'medium',
            ]
        );

        return $this->render('@CongregationManagerApp/territory/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form,
        ]);
    }

    public function show(int $id, Request $request): Response
    {
        $territory = $this->territoryRepository->findOneById($id);
        if ($territory === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('@CongregationManagerApp/territory/show.html.twig', [
            'territory' => $territory,
        ]);
    }

    public function s13(Request $request): Response
    {
        $currentDate = new DateTimeImmutable();
        $serviceYear = (int) $currentDate->format('Y');
        if ($currentDate >= DateTimeImmutable::createFromFormat('Y-m-d', $serviceYear . '-09-01')) {
            ++$serviceYear;
        }
        $years = [];
        for ($y = 2015; $y <= $serviceYear; $y++) {
            $years[$y] = $y;
        }
        $form = $this->createForm(ChoiceType::class, $serviceYear, [
            'choices' => $years,
            'placeholder' => false,
            'required' => true,
            'label' => 'cm.ui.service_year',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var int|mixed $serviceYear */
            $serviceYear = $form->getData();
            Assert::integer($serviceYear);
            $s13 = $this->s13Generator->generateByCongregation(
                $this->congregationContext->getCongregation(),
                $serviceYear
            );
            $wordFile = $this->s13Renderer->render($s13);
            Assert::isInstanceOf($wordFile, PhpWord::class);

            // Saving the document as OOXML file...
            $objWriter = IOFactory::createWriter($wordFile, 'Word2007');

            // Create a temporal file in the system
            $fileName = 'S-13_' . $serviceYear . '.docx';
            $tempFile = tempnam(sys_get_temp_dir(), $fileName);
            Assert::string($tempFile);

            // Write in the temporal filepath
            $objWriter->save($tempFile);

            // Send the temporal file as response (as an attachment)
            $response = new BinaryFileResponse($tempFile);
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName);

            return $response;
        }

        return $this->render('@CongregationManagerApp/territory/components/s_13.html.twig', [
            'form' => $form,
        ]);
    }
}
