<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Templates;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class Section
{
    public const DECORATION_MODE_NEVER = 0;
    public const DECORATION_MODE_ALWAYS = 1;
    public const DECORATION_MODE_NOT_FIRST = 2;

    private $header;
    private $footer;
    private $headerMode = self::DECORATION_MODE_ALWAYS;
    private $footerMode = self::DECORATION_MODE_ALWAYS;

    private $headerDrawCount = 0;
    private $footerDrawCount = 0;

    private $components = [];

    protected $fontFamily = 'DejaVu';

    public function setHeader(HeaderInterface $header): void
    {
        $this->header = $header;
    }

    public function setFooter(FooterInterface $footer): void
    {
        $this->footer = $footer;
    }

    public function addComponent(ComponentInterface $component): void
    {
        $this->components[] = $component;
    }

    public function render(Pdf $pdf, Section $lastFooterSection): void
    {
        $pdf->setHeaderFunction([$this, 'renderHeader']);
        $pdf->setFooterFunction([$lastFooterSection, 'renderFooter']);
        $pdf->addPage();
        $pdf->setFooterFunction([$this, 'renderFooter']);
        $this->renderContent($pdf);
    }

    public function renderHeader(Pdf $pdf): void
    {
        $this->headerDrawCount++;

        if ($this->headerMode == self::DECORATION_MODE_NEVER) {
            return;
        } elseif ($this->headerMode == self::DECORATION_MODE_NOT_FIRST && $this->headerDrawCount <= 1) {
            return;
        }

        if ($this->header) {
            $this->header->render($pdf);
        }
    }

    public function renderFooter(Pdf $pdf): void
    {
        $this->footerDrawCount++;

        if ($this->footerMode == self::DECORATION_MODE_NEVER) {
            return;
        } elseif ($this->footerMode == self::DECORATION_MODE_NOT_FIRST && $this->footerMode <= 1) {
            return;
        }

        if ($this->footer) {
            $this->footer->render($pdf);
        }
    }

    private function renderContent(Pdf $pdf): void
    {
        foreach ($this->components as $component) {
            $component->render($pdf);
        }
        //$this->renderTestContent($pdf);
    }

    private function renderTestContent(Pdf $pdf): void
    {
        $pdf->SetX(20);
        $pdf->SetY(25);
        $pdf->SetFont($this->fontFamily, '', 12);
        for ($i = 0; $i < 60; $i++) {
            $pdf->MultiCell(50, 5, "Max Mustermann $i");
        }
    }
}
