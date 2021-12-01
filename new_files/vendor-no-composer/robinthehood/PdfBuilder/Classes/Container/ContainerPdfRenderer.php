<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container;

use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererInterface;

class ContainerPdfRenderer implements ContainerRendererInterface
{
    public function render(ContainerRendererCanvasInterface $canvas, ContainerInterface $container): void
    {
        $renderContainer = $container->getCalcedContainer();

        // Draw Margin Box
        $box = $renderContainer->containerBox->getMarginBox();
        $color = $this->createColor(255, 0, 0);
        $this->drawBox($canvas, $box, $color);

        if (true) {
            // Draw Border Box
            $box = $renderContainer->containerBox->getBorderBox();
            $color = $this->createColor(0, 255, 255);
            $this->drawBox($canvas, $box, $color);

            // Draw Padding Box
            $box = $renderContainer->containerBox->getPaddingBox();
            $color = $this->createColor(0, 0, 255);
            $this->drawBox($canvas, $box, $color);

            // Draw Content Box
            $box = $renderContainer->containerBox->getContentBox();
            $colorBlue = $this->createColor(0, 255, 255);
            $this->drawBox($canvas, $box, $colorBlue);
        }

        $this->renderChilds($canvas, $container);
    }

    private function renderChilds(ContainerRendererCanvasInterface $canvas, ContainerInterface $container)
    {
        foreach ($container->getChildContainers() as $childContainer) {
            $containerRenderer = $childContainer->getContainerRenderer();
            $containerRenderer->render($canvas, $childContainer);
        }
    }

    private function drawBox(ContainerRendererCanvasInterface $canvas, array $box, $color)
    {
        $canvas->setColor($color['r'], $color['g'], $color['b']);

        // Top
        $line = $box['boxLines']['top'];
        $canvas->drawLine($line['x1'], $line['y1'], $line['x2'], $line['y2']);

        // Right
        $line = $box['boxLines']['right'];
        $canvas->drawLine($line['x1'], $line['y1'], $line['x2'], $line['y2']);

        // Bottom
        $line = $box['boxLines']['bottom'];
        $canvas->drawLine($line['x1'], $line['y1'], $line['x2'], $line['y2']);

        // Left
        $line = $box['boxLines']['left'];
        $canvas->drawLine($line['x1'], $line['y1'], $line['x2'], $line['y2']);
    }

    private function createColor($r, $g, $b)
    {
        return [
            'r' => $r,
            'g' => $g,
            'b' => $b
        ];
    }
}
