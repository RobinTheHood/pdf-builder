<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\DecoratorInterface;

class FooterDecorator extends Container implements DecoratorInterface
{
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
}
