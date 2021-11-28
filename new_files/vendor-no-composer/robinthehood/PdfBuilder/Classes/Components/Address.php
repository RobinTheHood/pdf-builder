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

    private $address = null;
    private $sender = null;

    public function __construct()
    {
        $this->address = new TextArea();
        $this->address->setPosition($this->basePositionX + 4, $this->basePositionY + 17.7);
        $this->address->setDimention(85 - 4, 27.3);
        $this->address->setFontSize(10);
        $this->address->setLineHeight(4.55);

        $this->sender = new TextArea();
        $this->sender->setPosition($this->basePositionX + 4, $this->basePositionY);
        $this->sender->setDimention(85 - 4, 17.7);
        $this->sender->setFontSize(7);
        $this->sender->setLineHeight(3.5);
        $this->sender->setVerticalAlign(TextArea::VERTICAL_ALIGN_BOTTOM);
    }

    public function setAddress(string $address): void
    {
        $this->address->setText($address);
    }

    public function setSender(string $sender): void
    {
        $this->sender->setText($sender);
    }

    public function render(Pdf $pdf): void
    {
        $pdf->SetDrawColor(255, 0, 0);

        // Hole Component Area
        $pdf->SetXY($this->basePositionX, $this->basePositionY); // Unit: mm
        $pdf->Cell(85, 45, '', 1);

        // Sender Zone
        $pdf->SetXY($this->basePositionX, $this->basePositionY); // Unit: mm
        //$pdf->Cell(85, 17.7, '', 1);
        $this->sender->render($pdf);

        // Address Zone
        $pdf->SetXY($this->basePositionX, $this->basePositionY + 17.7); // Unit: mm
        //$pdf->Cell(85, 27.3, '', 1);
        $this->address->render($pdf);
    }
}
