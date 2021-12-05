<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\ContainerRenderer;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;

class FoldMarkRenderer extends ContainerRenderer implements ContainerRendererInterface
{
    public function render(ContainerRendererCanvasInterface $canvas, ContainerInterface $container): void
    {
        parent::render($canvas, $container);

        $foldMark1PosY = 87; // Unit: mm
        $foldMark2PosY = 192; // Unit: mm
        $holeMarkPosY = 148.5; // Unit: mm

        $canvas->setColor(0, 0, 0);
        $canvas->drawLine(5, $foldMark1PosY, 8, $foldMark1PosY);
        $canvas->drawLine(5, $holeMarkPosY, 8, $holeMarkPosY);
        $canvas->drawLine(5, $foldMark2PosY, 8, $foldMark2PosY);
    }
}
