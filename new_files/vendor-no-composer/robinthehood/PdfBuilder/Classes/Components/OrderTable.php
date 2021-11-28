<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Table;

class OrderTable implements ComponentInterface
{
    private $basePositionX = 25; // Unit: mm
    private $basePositionY = 103.46; // Unit: mm

    private $table;

    public function __construct()
    {
        $this->table = new Table();
        $this->createHeading();
    }

    public function render(Pdf $pdf): void
    {
        $pdf->SetXY($this->basePositionX, $this->basePositionY);
        $this->table->render($pdf);

        // Hole Component Area
        $pdf->SetDrawColor(0, 255, 0);
        $pdf->SetXY($this->basePositionX, $this->basePositionY);
        $pdf->Cell(175, 157, '', 1);
    }

    private function createHeading(): void
    {
        $widthSum = 175; //mm
        $widthQuantity = 14; //mm
        $widthProductModel = 30; //mm
        $widthProductPrice = 28; //mm
        $widthProductTotalPrice = 28; //mm
        $widthProductVat = 14; //mm

        $widthProductName = $widthSum - $widthQuantity - $widthProductModel - $widthProductPrice - $widthProductTotalPrice - $widthProductVat;

        $this->table->setColumnWidths([
            $widthQuantity,
            $widthProductName,
            $widthProductModel,
            $widthProductPrice,
            $widthProductVat,
            $widthProductTotalPrice,
        ]);

        for ($i = 0; $i < 50; $i++) {
            $this->table->addRow([
                ['content' => 'Menge', 'alignment' => Pdf::CELL_ALIGN_LEFT],
                ['content' => 'Artikel'],
                ['content' => 'Artikel-Nr.'],
                ['content' => 'Einzelpreis', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
                ['content' => 'MwSt.', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
                ['content' => 'Gesamtpreis', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
            ], ['fontWeight' => Table::FONT_WEIGHT_BOLD, 'border' => Table::ROW_BORDER_BOTTOM, 'fontSize' => 8]);
        }
    }
}