<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\TextArea;

class Address extends Container implements ComponentInterface
{
    private $basePositionX = 20; // Unit: mm
    private $basePositionY = 27; // Unit: mm
    private $baseWidth = 85; // Unit: mm
    private $baseHeight = 45; // Unit: mm

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


        // Use new Container
        parent::__construct();

        $this->position = Container::POSITION_ABSOLUT;
        $this->containerBox->positionX->setValue($this->basePositionX);
        $this->containerBox->positionY->setValue($this->basePositionY);
        $this->containerBox->width->setValue($this->baseWidth);
        $this->containerBox->height->setValue($this->baseHeight);

        $this->address->position = Container::POSITION_ABSOLUT;
        $this->address->containerBox->positionX->setValue($this->basePositionX + 4);
        $this->address->containerBox->positionY->setValue($this->basePositionY + 17.7);
        $this->address->containerBox->width->setValue(81);
        $this->address->containerBox->height->setValue(27.3);

        $this->sender->position = Container::POSITION_ABSOLUT;
        $this->sender->containerBox->positionX->setValue($this->basePositionX + 4);
        $this->sender->containerBox->positionY->setValue($this->basePositionY);
        $this->sender->containerBox->width->setValue(81);
        $this->sender->containerBox->height->setValue(17.7);

        $this->addChildContainer($this->address);
        $this->addChildContainer($this->sender);
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
        // $this->renderBounds($pdf);

        // Sender Zone
        $pdf->SetXY($this->basePositionX, $this->basePositionY); // Unit: mm
        $this->sender->render($pdf);

        // Address Zone
        $this->address->calcBefore($pdf);
        $this->address->setCalcedPositionX($this->basePositionX + 4); // Unit: mm
        $this->address->setCalcedPositionY($this->basePositionY + 17.7); // Unit: mm
        $this->address->render($pdf);
    }

    // private function renderBounds(PDF $pdf): void
    // {
    //     // Hole Component Area
    //     $width = 85; // Unit: mm
    //     $height = 45; // Unit: mm

    //     $pdf->SetDrawColor(255, 0, 0);
    //     $pdf->SetXY($this->basePositionX, $this->basePositionY); // Unit: mm
    //     $pdf->Cell($width, $height, '', PDF::CELL_BORDER_ON);
    // }
}
