<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements\Traits;

use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

trait ComponentChildTrait
{
    private $childComponents = [];

    public function getChildComponents()
    {
        return $this->childComponents;
    }

    public function addChildComponent(ComponentInterface $container): void
    {
        $this->childComponents[] = $container;
    }

    private function getFirstChildComponent(): ?ComponentInterface
    {
        return $this->childComponents[0];
    }

    private function getLastChildComponent(): ?ComponentInterface
    {
        $lastIndex = count($this->childComponents) - 1;
        return $this->childComponents[$lastIndex];
    }
}
