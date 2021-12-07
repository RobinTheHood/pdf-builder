<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\ContainerRenderer;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;

class BarcodeRenderer extends ContainerRenderer implements ContainerRendererInterface
{
    private $lineWidth = 0.2;
    public function render(ContainerRendererCanvasInterface $canvas, ContainerInterface $container): void
    {
        parent::render($canvas, $container);

        /**
         * @var Barcode $textArea
         */
        $barcode = $container;

        $this->renderBarcode($canvas, $barcode);
    }

    private function renderBarcode(ContainerRendererCanvasInterface $canvas, Barcode $barcode): void
    {
        $contentBox = $barcode->getCalcedContainer()->containerBox->getContentBox();
        $posX = $contentBox['x'];
        $posY = $contentBox['y'];
        $lineHeight = $contentBox['height'];

        $code = $barcode->getCode();
        foreach (str_split($code) as $char) {
            if ($char == 0) {
                $canvas->setColor(255, 255, 255);
            } else {
                $canvas->setColor(0, 0, 0);
            }
            $canvas->setLineWidthToDo($this->lineWidth);
            $canvas->drawLine($posX, $posY, $posX, $posY + $lineHeight);
            $posX += $this->lineWidth;
        }
    }
}
