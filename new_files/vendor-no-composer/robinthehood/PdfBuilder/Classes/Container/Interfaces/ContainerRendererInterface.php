<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container\Interfaces;

interface ContainerRendererInterface
{
    public function render(ContainerRendererCanvasInterface $canvas, ContainerInterface $container): void;
}
