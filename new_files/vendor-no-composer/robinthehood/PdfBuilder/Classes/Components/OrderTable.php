<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Table;

class OrderTable extends Container
{
    /**
     * @var Table $table
     */
    private $table;

    public function __construct()
    {
        parent::__construct();

        $this->table = new Table();
        $this->createHeading();
        $this->table->containerBox->marginTop->setValue(5);
        $this->addChildContainer($this->table);
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
        ], [
            'fontWeight' => Pdf::FONT_STYLE_NORMAL,
            'fontSize' => 8,
            'paddingBottom' => 3
        ]);
    }

    private function createHeading(): void
    {
        $widthSum = 175; // Unit: mm
        $widthQuantity = 14; // Unit: mm
        $widthProductModel = 30; // Unit: mm
        $widthProductPrice = 28; // Unit: mm
        $widthProductTotalPrice = 28; // Unit: mm
        $widthProductVat = 14; // Unit: mm

        $widthProductName = $widthSum
            - $widthQuantity
            - $widthProductModel
            - $widthProductPrice
            - $widthProductTotalPrice
            - $widthProductVat;

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
        ], [
            'fontWeight' => Pdf::FONT_STYLE_BOLD,
            'border' => Table::ROW_BORDER_BOTTOM,
            'fontSize' => 10,
            'paddingBottom' => 2
        ]);
    }
}
