<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\ContainerRenderer;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class TextAreaRenderer extends ContainerRenderer implements ContainerRendererInterface
{
    public function render(ContainerRendererCanvasInterface $canvas, ContainerInterface $container): void
    {
        parent::render($canvas, $container);

        /**
         * @var TextArea $textArea
         */
        $textArea = $container;

        /**
         * @var Pdf $pdf
         */
        $pdf = $canvas;

        $this->renderTextArea($pdf, $textArea);
    }

    private function renderTextArea(Pdf $pdf, TextArea $textArea): void
    {
        $contentBox = $textArea->getCalcedContainer()->containerBox->getContentBox();
        $lines = $textArea->splitTextInLines($contentBox['width']);
        $x = $contentBox['x'];
        $y = $contentBox['y'];
        $lineHeight = $textArea->getFontHeight();

        $pdf->SetFont($textArea->getFontFamily(), $textArea->getFontWeight(), $textArea->getFontSize());
        foreach ($lines as $line) {
            $pdf->SetXY($x, $y);
            $pdf->Cell($contentBox['width'], $lineHeight, $line, Pdf::CELL_BORDER_NONE, Pdf::CELL_NEW_LINE_BELOW);
            $y += $lineHeight;
        }
    }
}
