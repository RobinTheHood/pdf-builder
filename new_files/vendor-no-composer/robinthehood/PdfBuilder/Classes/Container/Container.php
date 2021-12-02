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

    public function calcBeforeBefore(?ContainerInterface $parentContainer)
    {
        // $containerBox = $this->getCalcedContainer()->containerBox;
        // if ($containerBox->width->getIsSet()) {

        // }

        // if ($this->width == 0 && $this->height == 0) {
        //     $containerBox = $this->getCalcedContainer()->containerBox;
        //     $containerBox->height->setValue(20, ContainerValue::UNIT_PIXEL);
        // }
    }

    public function calcBetweenAfter(?ContainerInterface $parentContainer)
    {
        // if leaf container then
        if ($this->getChildContainers()) {
            $this->calcSetHeight();
            $this->calcStackChildContainersRelativ();
        }
    }

    public function calcAfterBefore(?ContainerInterface $parentContainer): void
    {
        if (!$parentContainer) {
            return;
        }

        //$positionY = $parentContainer->getCalcedContainer()->containerBox->positionY->getValue();
        $positionY = $parentContainer->getCalcedContainer()->containerBox->getContentBox()['y'];
        $positionY += $this->getCalcedContainer()->containerBox->positionY->getValue();
        $this->getCalcedContainer()->containerBox->positionY->setValue($positionY);

        //$positionX = $parentContainer->getCalcedContainer()->containerBox->positionX->getValue();
        $positionX = $parentContainer->getCalcedContainer()->containerBox->getContentBox()['x'];
        $positionX += $this->getCalcedContainer()->containerBox->positionX->getValue();
        $this->getCalcedContainer()->containerBox->positionX->setValue($positionX);

        if (!$this->getCalcedContainer()->containerBox->width->isSet()) {
            $width = $parentContainer->getCalcedContainer()->containerBox->width->getValue()
                - $this->getCalcedContainer()->containerBox->marginLeft->getValue()
                - $this->getCalcedContainer()->containerBox->borderLeft->getValue()
                - $this->getCalcedContainer()->containerBox->paddingLeft->getValue()
                - $this->getCalcedContainer()->containerBox->paddingRight->getValue()
                - $this->getCalcedContainer()->containerBox->borderRight->getValue()
                - $this->getCalcedContainer()->containerBox->marginRight->getValue();

            $this->getCalcedContainer()->containerBox->width->setValue($width);
        }
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

    private function calcStackChildContainers(): void
    {
        $calcContainter = $this->getCalcedContainer();
        // $positionX = $calcContainter->containerBox->positionX->getValue();
        // $positionY = $calcContainter->containerBox->positionY->getValue();
        $positionX = $calcContainter->containerBox->getContenBox()['x'];
        $positionY = $calcContainter->containerBox->getContenBox()['y'];
        foreach ($this->getChildContainers() as $childContainer) {
            $childCalcContainer = $childContainer->getCalcedContainer();
            $childCalcContainer->containerBox->positionX->setValue($positionX);
            $childCalcContainer->containerBox->positionY->setValue($positionY);
            $positionY += $childCalcContainer->containerBox->getMarginBox()['height'];
        }
    }

    private function calcStackChildContainersRelativ(): void
    {
        $positionY = 0;
        foreach ($this->getChildContainers() as $childContainer) {
            $childCalcContainer = $childContainer->getCalcedContainer();
            $childCalcContainer->containerBox->positionY->setValue($positionY);
            $positionY += $childCalcContainer->containerBox->getMarginBox()['height'];
        }
    }

    private function calcSetWidthOfChildContainers(): void
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
