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

    public function calcBefore(ContainerInterface $parentContainer)
    {
        if ($this->width == 0 && $this->height == 0) {
            $containerBox = $this->getCalcedContainer()->containerBox;
            $containerBox->height->setValue(20, ContainerValue::UNIT_PIXEL);
        }
    }

    public function calcBetween(ContainerInterface $parentContainer)
    {
        // display: block, position: relativ, text-align: left
        $calcContainter = $this->getCalcedContainer();
        $y = 0;
        foreach ($this->getChildContainers() as $childContainer) {
            $childCalcContainer = $childContainer->getCalcedContainer();

            $posX = $calcContainter->containerBox->positionX->getValue();
            $posY = $calcContainter->containerBox->positionY->getValue() + $y;
            $childCalcContainer->containerBox->positionX->setValue($posX);
            $childCalcContainer->containerBox->positionY->setValue($posY);

            if (!$childCalcContainer->containerBox->width->isSet()) {
                $width = $calcContainter->containerBox->width->getValue()
                    - $childCalcContainer->borderRight->getValue()
                    - $childCalcContainer->borderLeft->getValue();
                $childCalcContainer->containerBox->width->setValue($width);
            }
            $y += $childCalcContainer->containerBox->getMarginBox()['height'];
        }
    }

    public function calcBetweenAfter(ContainerInterface $parentContainer)
    {
        $calcContainter = $this->getCalcedContainer();
        $y = 0;
        foreach ($this->getChildContainers() as $childContainer) {
            $childCalcContainer = $childContainer->getCalcedContainer();

            $posX = $calcContainter->containerBox->positionX->getValue();
            $posY = $calcContainter->containerBox->positionY->getValue() + $y;
            $childCalcContainer->containerBox->positionX->setValue($posX);
            $childCalcContainer->containerBox->positionY->setValue($posY);

            if (!$childCalcContainer->containerBox->width->isSet()) {
                $width = $calcContainter->containerBox->width->getValue()
                    - $childCalcContainer->borderRight->getValue()
                    - $childCalcContainer->borderLeft->getValue();
                $childCalcContainer->containerBox->width->setValue($width);
            }
            $y += $childCalcContainer->containerBox->getMarginBox()['height'];
        }

        if ($this->getChildContainers()) {
            $calcContainter->containerBox->height->setValue($y);
        }
    }
}
