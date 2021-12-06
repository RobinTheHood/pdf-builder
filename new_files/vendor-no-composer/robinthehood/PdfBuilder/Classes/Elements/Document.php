<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class Document
{
    /**
     * @var int $leftMargin
     */
    private $leftMargin = 20;

    /**
     * @var string $fontFamily
     */
    private $fontFamily = 'DejaVu';

    /**
     * @var Section[] $sections
     */
    private $sections = [];

    /**
     * @var Pdf $pdf
     */
    private $pdf = null;

    public function addSection(Section $section): void
    {
        $this->sections[] = $section;
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

    private function initPdf(): void
    {
        $pdf = new Pdf();
        $pdf->AddFont($this->fontFamily, Pdf::FONT_STYLE_NORMAL, 'DejaVuSansCondensed.ttf', true);
        $pdf->AddFont($this->fontFamily, Pdf::FONT_STYLE_BOLD, 'DejaVuSansCondensed-Bold.ttf', true);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->SetCreator("PdfBuilder (c) 2021 Robin Wieschendorf");
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetDisplayMode('fullwidth');
        $pdf->SetTitle('Pdf Builder Test');
        $pdf->SetLeftMargin($this->leftMargin);
        $this->pdf = $pdf;
    }
}
