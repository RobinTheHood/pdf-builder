<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\Container;

class ContentArea extends Container
{
    private $basePositionX = 25; // Unit: mm
    private $basePositionY = 103.46; // Unit: mm
    private $baseWidth = 175; // Unit: mm

    public function __construct()
    {
        parent::__construct();

        $this->position = Container::POSITION_ABSOLUT;
        $this->containerBox->positionX->setValue($this->basePositionX);
        $this->containerBox->positionY->setValue($this->basePositionY);
        $this->containerBox->width->setValue($this->baseWidth);
    }
}
