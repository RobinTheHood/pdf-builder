<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container\Interfaces;

interface ContainerRendererCanvasInterface
{
    public function setColor(float $r, float $g, float $b, float $alpha = 1): void;
    public function drawLine(float $x1, float $y1, float $x2, float $y2): void;
}
