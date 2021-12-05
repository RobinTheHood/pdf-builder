<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\Container;

class Infoblock extends Container
{
    private $basePositionX = 125; // Unit: mm
    private $basePositionY = 32; // Unit: mm
    private $baseWidth = 75; // Unit: mm
    private $baseHeight = 103.46 - 32 - 8.46; // Unit: mm

    public function __construct()
    {
        parent::__construct();

        $this->position = Container::POSITION_ABSOLUT;
        $this->containerBox->positionX->setValue($this->basePositionX);
        $this->containerBox->positionY->setValue($this->basePositionY);
        $this->containerBox->width->setValue($this->baseWidth);
        $this->containerBox->height->setValue($this->baseHeight);
    }
}
