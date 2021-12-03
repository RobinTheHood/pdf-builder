<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class Infoblock extends Container implements ComponentInterface
{
    private $basePositionX = 125; // Unit: mm
    private $basePositionY = 32; // Unit: mm
    private $baseWidth = 75; // Unit: mm
    private $baseHeight = 103.46 - 32 - 8.46; // Unit: mm

    public function __construct()
    {
        // Use new Container
        parent::__construct();

        $this->position = Container::POSITION_ABSOLUT;
        $this->containerBox->positionX->setValue($this->basePositionX);
        $this->containerBox->positionY->setValue($this->basePositionY);
        $this->containerBox->width->setValue($this->baseWidth);
        $this->containerBox->height->setValue($this->baseHeight);
    }

    public function render(Pdf $pdf): void
    {
        return;
        $pdf->SetDrawColor(255, 0, 0);

        // Hole Component Area
        $pdf->SetXY($this->basePositionX, $this->basePositionY);
        $pdf->Cell(75, 103.46 - 32 - 8.46, '', PDF::CELL_BORDER_ON);
    }
}
