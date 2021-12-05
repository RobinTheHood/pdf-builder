<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class Document
{
    private $sections = [];

    //private $footerY = 35;
    private $leftMargin = 20;
    private $fontFamily = 'DejaVu';

    private $pdf = null;

    public function addSection(Section $section): void
    {
        $this->sections[] = $section;
    }

    public function calcComponents()
    {
        foreach ($this->sections as $section) {
            $section->calcComponents();
        }
    }

    public function render(): void
    {
        $this->initPdf();
        $prevSection = $this->sections[0] ?? null;
        foreach ($this->sections as $section) {
            $section->render($this->pdf, $prevSection);
            $prevSection = $section;
        }
        $this->pdf->Output();
    }

    private function initPdf()
    {
        $pdf = new Pdf();
        $pdf->AddFont($this->fontFamily, '', 'DejaVuSansCondensed.ttf', true);
        $pdf->AddFont($this->fontFamily, 'B', 'DejaVuSansCondensed-Bold.ttf', true);

        //$pdf->SetAutoPageBreak(true, $this->footerY);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->SetCreator("PdfBuilder (c) 2021 Robin Wieschendorf");
        //$pdf->AliasNbPages();

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetDisplayMode('fullwidth');
        $pdf->SetTitle('Pdf Builder Test');
        $pdf->SetLeftMargin($this->leftMargin);

        $this->pdf = $pdf;
    }
}
