<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container\Traits;

use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;

trait ContainerCalculationTrait
{
    private $calcedContainer;

    public function getCalcedContainer(): ContainerInterface
    {
        if (!$this->calcedContainer) {
            $this->calcedContainer = $this->copy();
        }
        return $this->calcedContainer;
    }

    public function calcAll()
    {
        $this->calcBeforeAll($this);
        $this->calcBetweenAll($this);
        $this->calcAfterAll($this);
    }

    public function calcBeforeAll(ContainerInterface $parentContainer)
    {
        $this->calcBefore($parentContainer);
        foreach ($this->childContainers as $childContainers) {
            $childContainers->calcBeforeAll($this);
        }
    }

    public function calcBetweenAll(ContainerInterface $parentContainer)
    {
        $this->calcBetween($parentContainer);
        foreach ($this->childContainers as $childContainers) {
            $childContainers->calcBetweenAll($this);
        }
        $this->calcBetweenAfter($parentContainer);
    }

    public function calcAfterAll()
    {
        $this->calcAfter();
        foreach ($this->childContainers as $childContainers) {
            $childContainers->calcAfterAll();
        }
    }

    public function calcBefore(ContainerInterface $parentContainer)
    {
    }

    public function calcBetween(ContainerInterface $parentContainer)
    {
    }

    public function calcAfter()
    {
    }

    public function calcBetweenAfter(ContainerInterface $parentContainer)
    {
    }
}
