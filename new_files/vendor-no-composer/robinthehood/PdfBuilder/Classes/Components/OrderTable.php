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
        $pdf->Cell(175, 157, '', PDF::CELL_BORDER_ON);
    }

    public function addItem(array $item): void
    {
        $this->table->addRow([
            ['content' => $item['quantity'], 'alignment' => Pdf::CELL_ALIGN_LEFT],
            ['content' => $item['name']],
            ['content' => $item['model']],
            ['content' => $item['price'], 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => $item['vat'], 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => $item['priceTotal'], 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], ['fontWeight' => PDF::FONT_WEIGHT_NORMAL, 'border' => Table::ROW_BORDER_BOTTOM, 'fontSize' => 8]);
    }

    private function createHeading(): void
    {
        $widthSum = 175; // Unit: mm
        $widthQuantity = 14; // Unit: mm
        $widthProductModel = 30; // Unit: mm
        $widthProductPrice = 28; // Unit: mm
        $widthProductTotalPrice = 28; // Unit: mm
        $widthProductVat = 14; // Unit: mm

        $widthProductName = $widthSum - $widthQuantity - $widthProductModel - $widthProductPrice - $widthProductTotalPrice - $widthProductVat;

        $this->table->setColumnWidths([
            $widthQuantity,
            $widthProductName,
            $widthProductModel,
            $widthProductPrice,
            $widthProductVat,
            $widthProductTotalPrice,
        ]);

        $this->table->addRow([
            ['content' => 'Menge', 'alignment' => Pdf::CELL_ALIGN_LEFT],
            ['content' => 'Artikel'],
            ['content' => 'Artikel-Nr.'],
            ['content' => 'Einzelpreis', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => 'MwSt.', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => 'Gesamtpreis', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], ['fontWeight' => PDF::FONT_WEIGHT_BOLD, 'border' => Table::ROW_BORDER_BOTTOM, 'fontSize' => 8]);
    }
}
