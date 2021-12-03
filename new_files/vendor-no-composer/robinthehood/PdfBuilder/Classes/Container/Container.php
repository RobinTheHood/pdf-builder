<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container;

use RobinTheHood\PdfBuilder\Classes\Container\ContainerBox;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Traits\ContainerCalculationTrait;
use RobinTheHood\PdfBuilder\Classes\Container\Traits\ContainerChildTrait;
use RobinTheHood\PdfBuilder\Classes\Container\Traits\ContainerCopyTrait;

class Container implements ContainerInterface
{
    use ContainerCopyTrait;
    use ContainerChildTrait;
    use ContainerCalculationTrait;

    public const POSITION_INITIAL = 0;
    public const POSITION_STATIC = 1;
    public const POSITION_ABSOLUT = 2;
    public const POSITION_RELATIVE = 3;

    /**
     * @var ContainerBox
     */
    public $containerBox;

    private $containerRenderer = null;

    public $position = self::POSITION_STATIC;

    public function __construct()
    {
        $this->containerBox = new ContainerBox();
        $this->containerRenderer = new ContainerRenderer();
    }

    public function getContainerRenderer(): ContainerRendererInterface
    {
        return $this->containerRenderer;
    }

    public function setContainerRenderer(ContainerRendererInterface $containerRenderer): void
    {
        $this->containerRenderer = $containerRenderer;
    }

    public function calcBetweenAfter(?ContainerInterface $parentContainer)
    {
        $this->calcSetWidth($parentContainer);
        $this->calcSetHeight();

        $this->calcStackChildContainersRelativ();

        if ($this->position == self::POSITION_STATIC) {
            $this->getCalcedContainer()->containerBox->positionX->setValue(0);
            $this->getCalcedContainer()->containerBox->positionY->setValue(0);
        }
    }

    public function calcAfterBefore(?ContainerInterface $parentContainer): void
    {
        if (!$parentContainer) {
            return;
        }

        if ($this->position != self::POSITION_ABSOLUT) {
            $positionY = $parentContainer->getCalcedContainer()->containerBox->getContentBox()['y'];
            $positionY += $this->getCalcedContainer()->containerBox->positionY->getValue();
            $this->getCalcedContainer()->containerBox->positionY->setValue($positionY);

            $positionX = $parentContainer->getCalcedContainer()->containerBox->getContentBox()['x'];
            $positionX += $this->getCalcedContainer()->containerBox->positionX->getValue();
            $this->getCalcedContainer()->containerBox->positionX->setValue($positionX);
        }
    }

    private function calcSetWidth(?ContainerInterface $parentContainer): void
    {
        if (!$parentContainer) {
            return;
        }

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

    protected function calcSetHeight(): void
    {
        if (!$this->getChildContainers()) {
            return;
        }

        if ($this->containerBox->height->isSet()) {
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
            if ($childContainer->position == self::POSITION_ABSOLUT) {
                continue;
            }

            $childCalcContainer = $childContainer->getCalcedContainer();
            $height += $childCalcContainer->containerBox->getMarginBox()['height'];
        }
        return $height;
    }

    private function calcStackChildContainersRelativ(): void
    {
        $positionY = 0;
        foreach ($this->getChildContainers() as $childContainer) {
            if ($childContainer->position == self::POSITION_ABSOLUT) {
                continue;
            }
            $childCalcContainer = $childContainer->getCalcedContainer();
            $childCalcContainer->containerBox->positionY->setValue($positionY);
            $positionY += $childCalcContainer->containerBox->getMarginBox()['height'];
        }
    }
}
