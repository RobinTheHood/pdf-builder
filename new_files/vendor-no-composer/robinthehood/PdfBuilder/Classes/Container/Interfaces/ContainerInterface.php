<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container\Interfaces;

interface ContainerInterface
{
    public function getMarginBox(): array;

    public function getBorderBox(): array;

    public function getPaddingBox(): array;

    public function getContentBox(): array;

    public function setMargin($top, $right = null, $bottom = null, $left = null): void;

    public function setBorder($top, $right = null, $bottom = null, $left = null): void;

    public function setPadding($top, $right = null, $bottom = null, $left = null): void;

    public function getChildContainers(): array;

    public function getContainerRenderer(): ContainerRendererInterface;

    public function getCalcedContainer(): ContainerInterface;
}
