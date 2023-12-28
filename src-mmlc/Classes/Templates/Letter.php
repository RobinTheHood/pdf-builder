<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Templates;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Section;
use RobinTheHood\PdfBuilder\Classes\Elements\Table;
use RobinTheHood\PdfBuilder\Classes\Elements\Document;
use RobinTheHood\PdfBuilder\Classes\Elements\FooterDecorator;
use RobinTheHood\PdfBuilder\Classes\Elements\HeaderDecorator;
use RobinTheHood\PdfBuilder\Classes\Elements\Image;
use RobinTheHood\PdfBuilder\Classes\Elements\PageDecorator;
use RobinTheHood\PdfBuilder\Classes\Components\FoldMark;
use RobinTheHood\PdfBuilder\Classes\Components\Address;

class Letter
{
    private $document;

    public function __construct()
    {
        $this->document = new Document();

        $section = new Section();
        $header = new HeaderDecorator();
        $footer = new FooterDecorator();
        $section->setHeaderDecorator($header);
        $section->setFooterDecorator($footer);

        $section2 = new Section();
        $section2->setHeaderDecorator($header);

        $section3 = new Section();
        $section3->setFooterDecorator($footer);

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

        //$footer->addComponent($tableFooter);

        $dinImage = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/din_5008_a.png');
        //$dinImage = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/rechnung_demo_1.png');
        $dinImage->setPositionX(0);
        $dinImage->setPositionY(0);
        $dinImage->setWidth(210);
        //$section->addComponent($dinImage);

        $image = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/logo_head.png');
        $image->setPositionX(145);
        $image->setPositionY(9);
        $image->setWidth(40);
        $section->addComponent($image);

        //$section->addComponent($table);

        //Address
        $address = new Address();
        $address->setAddress("Musterfirma GmbH\nz.H Max Mustermann\nHauptstraße 999\n12345 Neustadt\nDeutschland");
        $address->setSender("Max Mustermann - 12345 Neustadt 1\n");
        $section->addComponent($address);

        $pageDecorator = new PageDecorator();
        $pageDecorator->addComponent($dinImage);
        $pageDecorator->addComponent(new FoldMark());

        $section->setPageDecorator($pageDecorator);
    }

    public function render(): void
    {
        $this->document->render();
    }
}
