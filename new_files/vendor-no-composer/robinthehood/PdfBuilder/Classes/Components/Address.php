<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Elements\TextArea;

class Address extends Container
{
    private $basePositionX = 20; // Unit: mm
    private $basePositionY = 27; // Unit: mm
    private $baseWidth = 85; // Unit: mm
    private $baseHeight = 45; // Unit: mm

    private $address = null;
    private $sender = null;

    public function __construct()
    {
        parent::__construct();

        $this->address = new TextArea();
        $this->address->setFontSize(10);
        $this->address->setLineHeight(4.55);

        $this->sender = new TextArea();
        $this->sender->setFontSize(7);
        $this->sender->setLineHeight(3.5);
        $this->sender->setVerticalAlign(TextArea::VERTICAL_ALIGN_BOTTOM);

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
}
