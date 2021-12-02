<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container\Traits;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
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
        $this->calcBeforeAll(null);
        $this->calcBetweenAll(null);
        $this->calcAfterAll(null);
    }

    public function calcBeforeAll(?ContainerInterface $parentContainer)
    {
        $this->calcBeforeBefore($parentContainer);
        foreach ($this->childContainers as $childContainers) {
            $childContainers->calcBeforeAll($this);
        }
        $this->calcBeforeAfter($parentContainer);
    }

    public function calcBetweenAll(?ContainerInterface $parentContainer)
    {
        $this->calcBetweenBefore($parentContainer);
        foreach ($this->childContainers as $childContainers) {
            $childContainers->calcBetweenAll($this);
        }
        $this->calcBetweenAfter($parentContainer);
    }

    public function calcAfterAll(?ContainerInterface $parentContainer)
    {
        $this->calcAfterBefore($parentContainer);
        foreach ($this->childContainers as $childContainers) {
            $childContainers->calcAfterAll($this);
        }
        $this->calcAfterAfter($parentContainer);
    }

    public function calcBeforeBefore(?ContainerInterface $parentContainer)
    {
    }

    public function calcBeforeAfter(?ContainerInterface $parentContainer)
    {
    }

    public function calcBetweenBefore(?ContainerInterface $parentContainer)
    {
    }

    public function calcBetweenAfter(?ContainerInterface $parentContainer)
    {
    }

    public function calcAfterBefore(?ContainerInterface $parentContainer)
    {
    }

    public function calcAfterAfter(?ContainerInterface $parentContainer)
    {
    }
}
