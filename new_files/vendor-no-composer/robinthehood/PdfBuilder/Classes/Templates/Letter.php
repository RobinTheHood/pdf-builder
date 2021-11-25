<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Templates;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Section;
use RobinTheHood\PdfBuilder\Classes\Elements\Header;
use RobinTheHood\PdfBuilder\Classes\Elements\Footer;
use RobinTheHood\PdfBuilder\Classes\Elements\Table;

class Letter
{
    private $sections;

    // margins
    protected $leftMargin = 20;
    //protected $topMargin = 10;
    protected $footerY = -35;

    // Font-Type of Bill
    protected $fontFamily = 'DejaVu';

    public function __construct()
    {
        $section = new Section();
        $header = new Header();
        $footer = new Footer();
        $section->setHeader($header);
        $section->setFooter($footer);

        $section2 = new Section();
        $section2->setHeader($header);

        $section3 = new Section();
        $section3->setFooter($footer);

        $this->addSection($section); //Section with footer and header
        $this->addSection(new Section()); // Section without footer and header
        $this->addSection($section2); //Section only header
        $this->addSection($section3); //Section only footer


        // $cell = new Cell();
        // $cell->setText('Das ist ein Test');
        // $section->addComponent($cell);

        // $section2->addComponent($cell);
        // $section2->addComponent($cell);

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
        $section->addComponent($table);
    }


    public function addSection(Section $section): void
    {
        $this->sections[] = $section;
    }

    public function render(): void
    {
        $pdf = new Pdf();
        $pdf->AddFont($this->fontFamily, '', 'DejaVuSansCondensed.ttf', true);
        $pdf->AddFont($this->fontFamily, 'B', 'DejaVuSansCondensed-Bold.ttf', true);

        $pdf->SetAutoPageBreak(true, abs($this->footerY) + 10);
        $pdf->SetCreator("PdfBuilder (c) 2021 Robin Wieschendorf");
        //$pdf->AliasNbPages();

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetDisplayMode('fullwidth');
        $pdf->SetTitle('Pdf Builder Test');
        $pdf->SetLeftMargin($this->leftMargin);

        //$pdf->page = 1;
        $prevSection = $this->sections[0] ?? null;
        foreach ($this->sections as $section) {
            $section->render($pdf, $prevSection);
            $prevSection = $section;
        }
        $pdf->Output();
    }
}
