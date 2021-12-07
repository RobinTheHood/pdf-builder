<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Table;

class OrderTotalTable extends Container// implements ComponentInterface
{
    //private $basePositionX = 25; // Unit: mm
    //private $basePositionY = 103.46 + 30; // Unit: mm

    /**
     * @var Table $tableVat
     */
    private $tableVat;

    /**
     * @var Table $tableSum
     */
    private $tableSum;

    /**
     * @var Table $tableSum2
     */
    private $tableSum2;

    public function __construct()
    {
        parent::__construct();

        $this->initTableVat();
        $this->initTableSum();
        $this->initTableSum2();

        $this->addChildContainer($this->tableVat);
        $this->addChildContainer($this->tableSum);
        $this->addChildContainer($this->tableSum2);
    }

    private function initTableVat(): void
    {
        $this->tableVat = new Table();
        $this->tableVat->containerBox->borderTop->setValue(0.2);
        $this->tableVat->containerBox->paddingTop->setValue(1);


        $widthSum = 175; // Unit: mm
        $widthVat = 14; // Unit: mm
        $widthTotal = 28; // Unit: mm

        $widthName = $widthSum - $widthVat - $widthTotal;

        $this->tableVat->setColumnWidths([
            $widthName,
            $widthVat,
            $widthTotal,
        ]);

        $rowOptions = [
            'fontWeight' => PDF::FONT_STYLE_NORMAL,
            //'borderBottom' => Table::ROW_BORDER_BOTTOM,
            'fontSize' => 8,
            'paddingBottom' => 1
        ];

        $this->tableVat->addRow([
            ['content' => 'Gesamt (Brutto)', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => '7%', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => '89,00 €', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], $rowOptions);

        $this->tableVat->addRow([
            ['content' => 'Gesamt (Brutto)', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => '19%', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => '13,00 €', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], $rowOptions);
    }

    private function initTableSum(): void
    {
        $this->tableSum = new Table();
        $this->tableSum->containerBox->marginTop->setValue(1);
        $this->tableSum->containerBox->borderTop->setValue(0.2);
        $this->tableSum->containerBox->paddingTop->setValue(1);

        $widthSum = 175; // Unit: mm
        $widthTotal = 28 + 14; // Unit: mm

        $widthName = $widthSum - $widthTotal;

        $this->tableSum->setColumnWidths([
            $widthName,
            $widthTotal,
        ]);

        $rowOptions = [
            'fontWeight' => PDF::FONT_STYLE_NORMAL,
            //'borderBottom' => Table::ROW_BORDER_BOTTOM,
            'fontSize' => 8,
            'paddingBottom' => 1
        ];

        $this->tableSum->addRow([
            ['content' => 'Zwischensumme:', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => '102,00 €', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], $rowOptions);

        $this->tableSum->addRow([
            ['content' => 'Versandkosten:', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => '0,00 €', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], $rowOptions);

        $this->tableSum->addRow([
            ['content' => 'inkl. MwSt. 7%:', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => '5,82 €', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], $rowOptions);

        $this->tableSum->addRow([
            ['content' => 'inkl. MwSt. 19%:', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => '2,08 €', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], $rowOptions);
    }

    private function initTableSum2(): void
    {
        $this->tableSum2 = new Table();
        $this->tableSum2->containerBox->marginTop->setValue(1);
        $this->tableSum2->containerBox->borderTop->setValue(0.2);
        $this->tableSum2->containerBox->paddingTop->setValue(1);

        $widthSum = 175; // Unit: mm
        $widthTotal = 28 + 14; // Unit: mm

        $widthName = $widthSum - $widthTotal;

        $this->tableSum2->setColumnWidths([
            $widthName,
            $widthTotal,
        ]);

        $rowOptions = [
            'fontWeight' => PDF::FONT_STYLE_BOLD,
            //'borderBottom' => Table::ROW_BORDER_BOTTOM,
            'fontSize' => 10,
            'paddingBottom' => 1
        ];

        $this->tableSum2->addRow([
            ['content' => 'Summe:', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => '102,00 €', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], $rowOptions);
    }
}
