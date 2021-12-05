<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\ContainerRenderer;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;

class TextAreaRenderer extends ContainerRenderer implements ContainerRendererInterface
{
    public function render(ContainerRendererCanvasInterface $canvas, ContainerInterface $container): void
    {
        parent::render($canvas, $container);

        /**
         * @var TextArea $textArea
         */
        $textArea = $container;

        $this->renderTextArea($canvas, $textArea);
    }

    private function renderTextArea(ContainerRendererCanvasInterface $canvas, TextArea $textArea): void
    {
        $contentBox = $textArea->getCalcedContainer()->containerBox->getContentBox();
        $lines = $textArea->splitTextInLines($contentBox['width']);
        $x = $contentBox['x'];
        $y = $contentBox['y'];

        $lineHeight = $textArea->getLineHeight();
        if ($lineHeight === null) {
            $lineHeight = $textArea->getFontHeight();
        }

        $canvas->setFontToDo($textArea->getFontFamily(), $textArea->getFontWeight(), $textArea->getFontSize());
        foreach ($lines as $line) {
            $canvas->drawText($line, $x, $y, $contentBox['width'], $lineHeight);
            $y += $lineHeight;
        }
    }
}
