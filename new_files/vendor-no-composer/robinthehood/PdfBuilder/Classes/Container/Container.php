<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container;

use RobinTheHood\PdfBuilder\Classes\Container\ContainerBox;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Traits\ContainerCalculationTrait;
use RobinTheHood\PdfBuilder\Classes\Container\Traits\ContainerChildTrait;
use RobinTheHood\PdfBuilder\Classes\Container\Traits\ContainerCopyTrait;
use RobinTheHood\PdfBuilder\Classes\Container\Traits\ContainerLayoutTrait;

class Container implements ContainerInterface
{
    use ContainerCopyTrait;
    use ContainerChildTrait;
    use ContainerCalculationTrait;

    //use ContainerLayoutTrait;

    /**
     * @var ContainerBox
     */
    public $containerBox;

    private $containerRenderer;

    public function __construct()
    {
        $this->containerBox = new ContainerBox();
        $this->containerRenderer = new ContainerPdfRenderer();
    }

    public function getContainerRenderer(): ContainerRendererInterface
    {
        return $this->containerRenderer;
    }

    public function setContainerRenderer(ContainerRendererInterface $containerRenderer): void
    {
        $this->containerRenderer = $containerRenderer;
    }

    public function calcBefore(?ContainerInterface $parentContainer)
    {
        if ($this->width == 0 && $this->height == 0) {
            $containerBox = $this->getCalcedContainer()->containerBox;
            $containerBox->height->setValue(20, ContainerValue::UNIT_PIXEL);
        }
    }

    public function calcBetween(?ContainerInterface $parentContainer)
    {
        // display: block, position: relativ, text-align: left
        // $this->calcStackChildContainers();
        // $this->calcSetWidthOfChildContainers();
        // $this->calcSetHeight();
    }

    public function calcBetweenAfter(?ContainerInterface $parentContainer)
    {
        if (!$this->getChildContainers()) {
            // leaf container
        } else {
            // not a leaf container
            $this->calcSetHeight();
            $this->calcStackChildContainersRelativ();
        }
    }

    public function calcAfter(?ContainerInterface $parentContainer): void
    {
        if (!$parentContainer) {
            return;
        }

        $positionY = $parentContainer->getCalcedContainer()->containerBox->positionY->getValue();
        $positionY += $this->getCalcedContainer()->containerBox->positionY->getValue();
        $this->getCalcedContainer()->containerBox->positionY->setValue($positionY);

        $positionX = $parentContainer->getCalcedContainer()->containerBox->positionX->getValue();
        $positionX += $this->getCalcedContainer()->containerBox->positionX->getValue();
        $this->getCalcedContainer()->containerBox->positionX->setValue($positionX);
    }

    public function calcAfterAfter(?ContainerInterface $parentContainer)
    {
    }

    private function calcSetHeight(): void
    {
        if (!$this->getChildContainers()) {
            return;
        }
        $height = $this->calcHeight();
        $calcContainter = $this->getCalcedContainer();
        $calcContainter->containerBox->height->setValue($height);
    }

    private function calcHeight(): float
    {
        $height = 0;
        foreach ($this->getChildContainers() as $childContainer) {
            $childCalcContainer = $childContainer->getCalcedContainer();
            $height += $childCalcContainer->containerBox->getMarginBox()['height'];
        }
        return $height;
    }

    private function calcStackChildContainers()
    {
        $calcContainter = $this->getCalcedContainer();
        $positionX = $calcContainter->containerBox->positionX->getValue();
        $positionY = $calcContainter->containerBox->positionY->getValue();
        foreach ($this->getChildContainers() as $childContainer) {
            $childCalcContainer = $childContainer->getCalcedContainer();
            $childCalcContainer->containerBox->positionX->setValue($positionX);
            $childCalcContainer->containerBox->positionY->setValue($positionY);
            $positionY += $childCalcContainer->containerBox->getMarginBox()['height'];
        }
    }

    private function calcStackChildContainersRelativ()
    {
        $positionY = 0;
        foreach ($this->getChildContainers() as $childContainer) {
            $childCalcContainer = $childContainer->getCalcedContainer();
            $childCalcContainer->containerBox->positionY->setValue($positionY);
            $positionY += $childCalcContainer->containerBox->getMarginBox()['height'];
        }
    }

    private function calcSetWidthOfChildContainers()
    {
        $calcContainter = $this->getCalcedContainer();
        foreach ($this->getChildContainers() as $childContainer) {
            $childCalcContainer = $childContainer->getCalcedContainer();
            if ($childCalcContainer->containerBox->width->isSet()) {
                continue;
            }

            $width = $calcContainter->containerBox->width->getValue()
                - $childCalcContainer->containerBox->borderRight->getValue()
                - $childCalcContainer->containerBox->borderLeft->getValue();
            $childCalcContainer->containerBox->width->setValue($width);
        }
    }
}
