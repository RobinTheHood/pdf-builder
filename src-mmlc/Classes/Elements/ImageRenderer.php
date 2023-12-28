<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\ContainerRenderer;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;

class ImageRenderer extends ContainerRenderer implements ContainerRendererInterface
{
    public function render(ContainerRendererCanvasInterface $canvas, ContainerInterface $container): void
    {
        parent::render($canvas, $container);

        /**
         * @var Image $textArea
         */
        $image = $container;

        $this->renderTextArea($canvas, $image);
    }

    private function renderTextArea(ContainerRendererCanvasInterface $canvas, Image $image): void
    {
        $contentBox = $image->getCalcedContainer()->containerBox->getContentBox();
        $canvas->drawImage(
            $image->getImagePath(),
            $contentBox['x'],
            $contentBox['y'],
            $contentBox['width'],
            $contentBox['height']
        );
    }
}
