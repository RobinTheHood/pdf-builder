<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class Document
{
    private $sections = [];

    private $leftMargin = 20;
    private $footerY = -25;
    private $fontFamily = 'DejaVu';

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

        $prevSection = $this->sections[0] ?? null;
        foreach ($this->sections as $section) {
            $section->render($pdf, $prevSection);
            $prevSection = $section;
        }
        $pdf->Output();
    }
}
