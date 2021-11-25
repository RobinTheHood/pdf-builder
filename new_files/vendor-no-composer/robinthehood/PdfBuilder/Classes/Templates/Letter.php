<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Templates;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Section;
use RobinTheHood\PdfBuilder\Classes\Elements\Header;
use RobinTheHood\PdfBuilder\Classes\Elements\Footer;
use RobinTheHood\PdfBuilder\Classes\Elements\Table;
use RobinTheHood\PdfBuilder\Classes\Elements\Document;
use RobinTheHood\PdfBuilder\Classes\Elements\Image;

class Letter
{
    private $document;

    public function __construct()
    {
        $this->document = new Document();

        $section = new Section();
        $header = new Header();
        $footer = new Footer();
        $section->setHeader($header);
        $section->setFooter($footer);

        $section2 = new Section();
        $section2->setHeader($header);

        $section3 = new Section();
        $section3->setFooter($footer);

        $this->document->addSection($section); //Section with footer and header
        $this->document->addSection(new Section()); // Section without footer and header
        $this->document->addSection($section2); //Section only header
        $this->document->addSection($section3); //Section only footer

        $table = new Table();

        $width = 29;
        $table->setColumnWidths([
            $width,
            $width,
            $width,
            $width,
            $width,
            $width
        ]);

        $table->addRow([
            ['content' => 'Spalte 1', 'alignment' => Pdf::CELL_ALIGN_LEFT],
            ['content' => 'Spalte 2'],
            ['content' => 'Spalte 3'],
            ['content' => 'Spalte 4', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => 'Spalte 5', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => 'Spalte 6', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], ['fontWeight' => Table::FONT_WEIGHT_BOLD, 'border' => Table::ROW_BORDER_BOTTOM]);

        for ($i = 0; $i < 60; $i++) {
            $table->addRow([
                ['content' => 'Inhalt 1', 'alignment' => Pdf::CELL_ALIGN_LEFT],
                ['content' => 'Inhalt 2'],
                ['content' => 'Inhalt 3'],
                ['content' => 'Inhalt 4', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
                ['content' => 'Inhalt 5', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
                ['content' => 'Inhalt 6', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
            ], ['fontWeight' => Table::FONT_WEIGHT_NORMAL, 'border' => Table::ROW_BORDER_BOTTOM]);
        }

        $table->addRow([
            ['content' => 'Inhalt 1', 'alignment' => Pdf::CELL_ALIGN_LEFT],
            ['content' => 'Inhalt 2'],
            ['content' => 'Inhalt 3'],
            ['content' => 'Inhalt 4', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => 'Inhalt 5', 'alignment' => Pdf::CELL_ALIGN_RIGHT],
            ['content' => 'Inhalt 6', 'alignment' => Pdf::CELL_ALIGN_RIGHT]
        ], ['fontWeight' => Table::FONT_WEIGHT_NORMAL, 'border' => Table::ROW_BORDER_BOTTOM]);

        $tableFooter = new Table();

        $width = 60;
        $tableFooter->setColumnWidths([
            $width,
            $width,
            $width,
        ]);

        $tableFooter->addRow([
            ['content' => "MAX MUSTERFIRMA\nMustermann Straße 1\n12345 Musterstadt", 'alignment' => Pdf::CELL_ALIGN_LEFT],
            ['content' => "www.musterfirma.de\ninfo@musterfirma.de\n+49 1234 1111-0", 'alignment' => Pdf::CELL_ALIGN_LEFT],
            ['content' => "BLZ: 123456789\nIBAN: DE123456789123456789\nUSt-ID: DE123456789", 'alignment' => Pdf::CELL_ALIGN_LEFT],
        ], ['fontWeight' => Table::FONT_WEIGHT_NORMAL, 'border' => Table::ROW_BORDER_NONE]);

        $footer->addComponent($tableFooter);

        $section->addComponent(new Image());
        $section->addComponent($table);
    }

    public function render(): void
    {
        $this->document->render();
    }
}
