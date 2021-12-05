<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\DecoratorInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\ComponentChildTrait;

class FooterDecorator extends Container implements DecoratorInterface
{
    // use ComponentChildTrait;

    // private $posY = -35;

    public function __construct()
    {
        parent::__construct();

        $this->position = Container::POSITION_ABSOLUT;
        $this->containerBox->positionX->setValue(0);
        $this->containerBox->positionY->setValue(297 - 35);
        $this->containerBox->width->setValue(190);
        $this->containerBox->height->setValue(35);
        $this->containerBox->paddingLeft->setValue(20);
    }

    // public function render(Pdf $pdf): void
    // {
    //     $pdf->SetY($this->posY);
    //     foreach ($this->childComponents as $childComponent) {
    //         $childComponent->render($pdf);
    //     }
    // }
}
