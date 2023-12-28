<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container\Traits;

use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;

trait ContainerChildTrait
{
    private $childContainers = [];

    public function getChildContainers(): array
    {
        return $this->childContainers;
    }

    public function addChildContainer(ContainerInterface $container): void
    {
        $this->childContainers[] = $container;
    }

    private function getFirstChildContainer(): ?ContainerInterface
    {
        return $this->childContainers[0];
    }

    private function getLastChildContainer(): ?ContainerInterface
    {
        $lastIndex = count($this->childContainers) - 1;
        return $this->childContainers[$lastIndex];
    }
}
