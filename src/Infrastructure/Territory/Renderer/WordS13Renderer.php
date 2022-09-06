<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Renderer;

use CongregationManager\Domain\Territory\Renderer\S13RendererInterface;
use CongregationManager\Domain\Territory\S13\Page;
use CongregationManager\Domain\Territory\S13\Row;
use CongregationManager\Domain\Territory\S13\S13;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Border;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\TextAlignment;
use Symfony\Contracts\Translation\TranslatorInterface;

final class WordS13Renderer implements S13RendererInterface
{
    private const TERRITORY_COLUMN_CM = 1.25;

    private const LAST_DATE_COMPLETED_COLUMN_CM = 2.25;

    private const DATE_ASSIGNED_COLUMN_CM = 2;

    private const DATE_COMPLETED_COLUMN_CM = 1.75;

    private const HEADER_BACKGROUND_COLOR = 'd9d9d9';

    private const DOCUMENT_PRINTED_DATE = '1/22';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function render(S13 $s13): PhpWord
    {
        $wordFile = new PhpWord();
        $wordFile->setDefaultFontName('Arial');
        $wordFile->setDefaultFontSize(11);

        foreach ($s13->getPages() as $page) {
            $this->addPage($wordFile, $page);
        }

        return $wordFile;
    }

    private function addPage(PhpWord $wordFile, Page $page): void
    {
        // Title
        $wordFile->addTitleStyle(
            0,
            [
                'bold' => true,
                'size' => 14,
            ],
            [
                'alignment' => Jc::CENTER,
                'spaceAfter' => Converter::cmToTwip(0.5),
            ],
        );
        $pageSection = $wordFile->addSection([
            'marginTop' => Converter::cmToTwip(2),
            'marginBottom' => Converter::cmToTwip(2),
            'marginLeft' => Converter::cmToTwip(1.25),
            'marginRight' => Converter::cmToTwip(1.25),
        ]);
        $pageSection->addTitle($this->translator->trans('cm.s_13.title'), 0);

        // Service year
        $serviceYearTable = $pageSection->addTable();
        $this->addServiceYear($serviceYearTable, (string) $page->getServiceYear());
        $pageSection->addTextBreak();

        // Assignments table
        $assignmentsTable = $pageSection->addTable([
            'borderColor' => '000000',
            'borderSize' => Converter::pointToTwip(0.5),
            'borderStyle' => Border::SINGLE,
        ]);
        $this->addAssignmentsTableHeader($assignmentsTable);
        $last = $page->getRows()
            ->last();
        foreach ($page->getRows() as $row) {
            $this->addAssignmentsTableRow($assignmentsTable, $row, $last === $row);
        }
        $pageSection->addText($this->translator->trans('cm.s_13.note'), [
            'size' => 10,
        ]);
        $footer = $pageSection->addFooter();
        $footer->addText($this->translator->trans('cm.s_13.code') . '  ' . self::DOCUMENT_PRINTED_DATE);
    }

    private function addServiceYear(Table $serviceYearTable, string $year): void
    {
        $serviceYearTable->addRow();
        $serviceYearTableLeftColumn = $serviceYearTable->addCell(Converter::cmToTwip(3.75));
        $serviceYearTableRightColumn = $serviceYearTable->addCell(
            Converter::cmToTwip(2.25),
            [
                'borderBottomColor' => '000000',
                'borderBottomSize' => Converter::pointToTwip(0.5),
                'borderBottomStyle' => Border::SINGLE,
            ]
        );
        $serviceYearTableLeftColumn->addText(
            $this->translator->trans('cm.s_13.service_year'),
            [
                'bold' => true,
                'size' => 12,
            ]
        );
        $serviceYearTableRightColumn->addText(
            $year,
            [
                'bold' => true,
                'size' => 12,
            ],
            [
                'alignment' => Jc::CENTER,
            ],
        );
    }

    private function addAssignmentsTableHeader(Table $assignmentsTable): void
    {
        // First row
        $assignmentsTable->addRow();
        $assignmentsTableTerritoryColumn = $assignmentsTable->addCell(
            Converter::cmToTwip(self::TERRITORY_COLUMN_CM),
            [
                'vMerge' => 'restart',
                'valign' => TextAlignment::CENTER,
                'bgColor' => self::HEADER_BACKGROUND_COLOR,
                'borderLeftSize' => Converter::pointToTwip(1.25),
                'borderTopSize' => Converter::pointToTwip(1.25),
            ],
        );
        $assignmentsTableTerritoryColumn->addText(
            $this->translator->trans('cm.s_13.territory_number'),
            [
                'size' => 9,
            ],
            [
                'alignment' => Jc::CENTER,
            ],
        );
        $assignmentsTableLastDateCompletedColumn = $assignmentsTable->addCell(
            Converter::cmToTwip(self::LAST_DATE_COMPLETED_COLUMN_CM),
            [
                'vMerge' => 'restart',
                'valign' => TextAlignment::CENTER,
                'bgColor' => self::HEADER_BACKGROUND_COLOR,
                'borderTopSize' => Converter::pointToTwip(1.25),
                'borderRightSize' => Converter::pointToTwip(1.25),
            ],
        );
        $assignmentsTableLastDateCompletedColumn->addText(
            $this->translator->trans('cm.s_13.last_date_completed'),
            [
                'size' => 9,
            ],
            [
                'alignment' => Jc::CENTER,
            ],
        );
        for ($i = 1; $i <= Row::MAX_COLUMNS_ALLOWED; $i++) {
            $lastColumnParagraphStyle = [];
            if ($i === Row::MAX_COLUMNS_ALLOWED) {
                $lastColumnParagraphStyle = [
                    'borderRightSize' => Converter::pointToTwip(1.25),
                ];
            }
            $assignmentsTableAssignedToColumn = $assignmentsTable->addCell(
                Converter::cmToTwip(self::DATE_ASSIGNED_COLUMN_CM + self::DATE_COMPLETED_COLUMN_CM),
                array_merge($lastColumnParagraphStyle, [
                    'gridSpan' => 2,
                    'valign' => TextAlignment::CENTER,
                    'bgColor' => self::HEADER_BACKGROUND_COLOR,
                    'borderTopSize' => Converter::pointToTwip(1.25),
                ]),
            );
            $assignmentsTableAssignedToColumn->addText(
                $this->translator->trans('cm.s_13.assigned_to'),
                [
                    'size' => 9,
                ],
                [
                    'alignment' => Jc::CENTER,
                ],
            );
        }

        // Second row
        $assignmentsTable->addRow();
        $assignmentsTable->addCell(null, [
            'vMerge' => 'continue',
            'borderLeftSize' => Converter::pointToTwip(1.25),
        ]);
        $assignmentsTable->addCell(null, [
            'vMerge' => 'continue',
            'borderRightSize' => Converter::pointToTwip(1.25),
        ]);
        for ($i = 1; $i <= Row::MAX_COLUMNS_ALLOWED; $i++) {
            $assignmentsTableDateAssignedColumn = $assignmentsTable->addCell(
                Converter::cmToTwip(self::DATE_ASSIGNED_COLUMN_CM),
                [
                    'valign' => TextAlignment::CENTER,
                    'bgColor' => self::HEADER_BACKGROUND_COLOR,
                ],
            );
            $assignmentsTableDateAssignedColumn->addText(
                $this->translator->trans('cm.s_13.date_assigned'),
                [
                    'size' => 8,
                ],
                [
                    'alignment' => Jc::CENTER,
                ],
            );
            $lastColumnParagraphStyle = [];
            if ($i === Row::MAX_COLUMNS_ALLOWED) {
                $lastColumnParagraphStyle = [
                    'borderRightSize' => Converter::pointToTwip(1.25),
                ];
            }
            $assignmentsTableDateCompletedColumn = $assignmentsTable->addCell(
                Converter::cmToTwip(self::DATE_COMPLETED_COLUMN_CM),
                array_merge($lastColumnParagraphStyle, [
                    'valign' => TextAlignment::CENTER,
                    'bgColor' => self::HEADER_BACKGROUND_COLOR,
                ]),
            );
            $assignmentsTableDateCompletedColumn->addText(
                $this->translator->trans('cm.s_13.date_completed'),
                [
                    'size' => 8,
                ],
                [
                    'alignment' => Jc::CENTER,
                    'bgColor' => self::HEADER_BACKGROUND_COLOR,
                ],
            );
        }
    }

    private function addAssignmentsTableRow(Table $assignmentsTable, Row $row, bool $isLast = false): void
    {
        $lastRowParagraphStyle = [];
        if ($isLast) {
            $lastRowParagraphStyle = [
                'borderBottomSize' => Converter::pointToTwip(1.25),
            ];
        }
        // First row
        $assignmentsTable->addRow();
        $assignmentsTableTerritoryColumn = $assignmentsTable->addCell(
            Converter::cmToTwip(self::TERRITORY_COLUMN_CM),
            array_merge($lastRowParagraphStyle, [
                'vMerge' => 'restart',
                'valign' => TextAlignment::CENTER,
                'borderLeftSize' => Converter::pointToTwip(1.25),
            ]),
        );
        $assignmentsTableTerritoryColumn->addText(
            (string) $row->getTerritory()
                ->getNumber(),
            [
                'size' => 11,
            ],
            [
                'alignment' => Jc::CENTER,
            ],
        );
        $assignmentsTableLastDateCompletedColumn = $assignmentsTable->addCell(
            Converter::cmToTwip(self::LAST_DATE_COMPLETED_COLUMN_CM),
            array_merge($lastRowParagraphStyle, [
                'vMerge' => 'restart',
                'valign' => TextAlignment::CENTER,
                'borderRightSize' => Converter::pointToTwip(1.25),
            ]),
        );
        $assignmentsTableLastDateCompletedColumn->addText(
            (string) $row->getLastRevocationDate()?->format('d-m-Y'),
            [
                'size' => 9,
            ],
            [
                'alignment' => Jc::CENTER,
            ],
        );
        for ($i = 1; $i <= Row::MAX_COLUMNS_ALLOWED; $i++) {
            $lastColumnParagraphStyle = [];
            if ($i === Row::MAX_COLUMNS_ALLOWED) {
                $lastColumnParagraphStyle = [
                    'borderRightSize' => Converter::pointToTwip(1.25),
                ];
            }
            $assignmentsTableAssignedToColumn = $assignmentsTable->addCell(
                Converter::cmToTwip(self::DATE_ASSIGNED_COLUMN_CM + self::DATE_COMPLETED_COLUMN_CM),
                array_merge($lastColumnParagraphStyle, [
                    'gridSpan' => 2,
                    'valign' => TextAlignment::CENTER,
                ]),
            );
            $territoryAssignment = $row->getTerritoryAssignments()
                ->get($i);
            $assignmentsTableAssignedToColumn->addText(
                $territoryAssignment ? (string) $territoryAssignment->getBrother() : '',
                [
                    'size' => 9,
                ],
                [
                    'alignment' => Jc::CENTER,
                ],
            );
        }

        // Second row
        $assignmentsTable->addRow();
        $assignmentsTable->addCell(null, [
            'vMerge' => 'continue',
            'borderLeftSize' => Converter::pointToTwip(1.25),
            'borderBottomSize' => Converter::pointToTwip(1.25),
        ]);
        $assignmentsTable->addCell(null, [
            'vMerge' => 'continue',
            'borderRightSize' => Converter::pointToTwip(1.25),
            'borderBottomSize' => Converter::pointToTwip(1.25),
        ]);
        for ($i = 1; $i <= Row::MAX_COLUMNS_ALLOWED; $i++) {
            $territoryAssignment = $row->getTerritoryAssignments()
                ->get($i);
            $assignmentsTableDateAssignedColumn = $assignmentsTable->addCell(
                Converter::cmToTwip(self::DATE_ASSIGNED_COLUMN_CM),
                array_merge($lastRowParagraphStyle, [
                    'valign' => TextAlignment::CENTER,
                ]),
            );
            $assignmentsTableDateAssignedColumn->addText(
                $territoryAssignment ? $territoryAssignment->getAssignmentDate()
                    ->format('d-m-Y') : '',
                [
                    'size' => 8,
                ],
                [
                    'alignment' => Jc::CENTER,
                ],
            );
            $lastColumnParagraphStyle = [];
            if ($i === Row::MAX_COLUMNS_ALLOWED) {
                $lastColumnParagraphStyle = [
                    'borderRightSize' => Converter::pointToTwip(1.25),
                ];
            }
            $assignmentsTableDateCompletedColumn = $assignmentsTable->addCell(
                Converter::cmToTwip(self::DATE_COMPLETED_COLUMN_CM),
                array_merge($lastColumnParagraphStyle, $lastRowParagraphStyle, [
                    'valign' => TextAlignment::CENTER,
                ]),
            );
            $assignmentsTableDateCompletedColumn->addText(
                $territoryAssignment ? (string) $territoryAssignment->getRevocationDate()?->format('d-m-Y') : '',
                [
                    'size' => 8,
                ],
                [
                    'alignment' => Jc::CENTER,
                ],
            );
        }
    }
}
