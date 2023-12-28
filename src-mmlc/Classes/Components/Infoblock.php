<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Elements\Barcode;
use RobinTheHood\PdfBuilder\Classes\Elements\Table;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class Infoblock extends Container
{
    private $basePositionX = 125; // Unit: mm
    private $basePositionY = 32; // Unit: mm
    private $baseWidth = 75; // Unit: mm
    private $baseHeight = 103.46 - 32 - 8.46; // Unit: mm

    public function __construct()
    {
        parent::__construct();

        $this->position = Container::POSITION_ABSOLUT;
        $this->containerBox->positionX->setValue($this->basePositionX);
        $this->containerBox->positionY->setValue($this->basePositionY);
        $this->containerBox->width->setValue($this->baseWidth);
        $this->containerBox->height->setValue($this->baseHeight);

        $table = new Table();

        $table->setColumnWidths([
            30,
            50
        ]);

        $rowSettings = [
            'fontWeight' => Pdf::FONT_STYLE_NORMAL,
            'borderBottom' => Table::ROW_BORDER_BOTTOM,
            'fontSize' => 10,
            'paddingBottom' => 1,
            'marginBottom' => 1
        ];

        $table->addRow([
            ['content' => 'Rechnung'], ['content' => 'R-123456']
        ], $rowSettings);

        $table->addRow([
            ['content' => 'Datum'], ['content' => '24.12.2021']
        ], $rowSettings);

        $table->addRow([
            ['content' => 'Kunde'], ['content' => 'K-123456']
        ], $rowSettings);

        $table->addRow([
            ['content' => 'Bestellung'], ['content' => 'O-123456']
        ], $rowSettings);

        $table->addRow([
            ['content' => 'Zahnungsart'], ['content' => 'Vorkasse und PayPal Plus']
        ], $rowSettings);

        $this->addChildContainer($table);

        $barcode = new Barcode();
        $barcode->containerBox->height->setValue(15);
        $barcode->setData('R-123456 / K-123456');
        $this->addChildContainer($barcode);
    }
}
