<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container\Interfaces;

interface ContainerInterface
{
    public function getChildContainers(): array;

    public function getContainerRenderer(): ContainerRendererInterface;

    public function getCalcedContainer(): ContainerInterface;
}
