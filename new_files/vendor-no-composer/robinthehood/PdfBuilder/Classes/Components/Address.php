<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\TextArea;

class Address implements ComponentInterface
{
    private $basePositionX = 20; // Unit: mm
    private $basePositionY = 27; // Unit: mm

    private $addressZone = null;

    public function __construct()
    {
        $this->addressZone = new TextArea();
        $this->addressZone->setPosition($this->basePositionX + 4, $this->basePositionY + 17.7);
        $this->addressZone->setDimention(85 - 4, 27.3);
        $this->addressZone->setFontSize(10);
        $this->addressZone->setLineHeight(4.55);
    }

    public function setAddress(string $address): void
    {
        $this->addressZone->setText($address);
    }

    public function render(Pdf $pdf): void
    {
        $pdf->SetDrawColor(255, 0, 0);

        // Hole Component Area
        $pdf->SetXY($this->basePositionX, $this->basePositionY); // Unit: mm
        $pdf->Cell(85, 45, '', 1);

        // Sender Zone
        $pdf->SetXY($this->basePositionX, $this->basePositionY); // Unit: mm
        $pdf->Cell(85, 17.7, '', 1);

        // Address Zone
        $pdf->SetXY($this->basePositionX, $this->basePositionY + 17.7); // Unit: mm
        $pdf->Cell(85, 27.3, '', 1);
        $this->addressZone->render($pdf);
    }
}
