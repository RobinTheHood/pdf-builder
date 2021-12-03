<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\ComponentChildTrait;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class ContentArea extends Container implements ComponentInterface
{
    use ComponentChildTrait;

    private $basePositionX = 25; // Unit: mm
    private $basePositionY = 103.46; // Unit: mm
    private $baseWidth = 175; // Unit: mm
    private $baseHeight = 100; // Unit: mm (only needed for tests)

    public function __construct()
    {
        // Use new Container
        parent::__construct();

        $this->position = Container::POSITION_ABSOLUT;
        $this->containerBox->positionX->setValue($this->basePositionX);
        $this->containerBox->positionY->setValue($this->basePositionY);
        $this->containerBox->width->setValue($this->baseWidth);
        $this->containerBox->height->setValue($this->baseHeight); // (only needed for tests)
    }

    public function render(Pdf $pdf): void
    {
        $this->calcedPositionX = 25;
        $this->calcedPositionY = 103.46;

        $this->calcComponents($pdf);
        $this->renderComponents($pdf);
    }

    private function calcComponents(Pdf $pdf)
    {
        foreach ($this->childComponents as $childComponent) {
            $childComponent->setDimensionWidth(175);
            $childComponent->calcBefore($pdf);
        }

        $y = $this->calcedPositionY;
        foreach ($this->childComponents as $childComponent) {
            $x = $this->calcedPositionX + $childComponent->getPositionX();
            $childComponent->setCalcedPositionX($x);
            $childComponent->setCalcedPositionY($y);
            $y += $childComponent->getCalcedDimensionHeight();
        }

        foreach ($this->childComponents as $childComponent) {
            $childComponent->calcComponents();
        }
    }

    private function renderComponents(Pdf $pdf): void
    {
        foreach ($this->childComponents as $childComponent) {
            $childComponent->render($pdf);
        }
    }
}
