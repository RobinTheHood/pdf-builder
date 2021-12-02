<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements\Traits;

use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

trait ComponentTrait
{
    private $positionX = 0;
    private $positionY = 0;
    private $calcedPositionX = 0;
    private $calcedPositionY = 0;
    private $dimensionWidth = 0;
    private $dimensionHeight = 0;
    private $calcedDimensionWidth = 0;
    private $calcedDimensionHeight = 0;

    private $positionMode = ComponentInterface::POSITION_MODE_RELATIVE;
    private $positionSetX = false;
    private $positionSetY = false;

    private $components = [];

    public function getPositionX(): float
    {
        return $this->positionX;
    }

    public function getPositionY(): float
    {
        return $this->positionY;
    }

    public function getDimensionWidth(): float
    {
        return $this->dimensionWidth;
    }

    public function getDimensionHeight(): float
    {
        return $this->dimensionHeight;
    }

    public function getCalcedDimensionWidth(): float
    {
        return $this->calcedDimensionWidth;
    }

    public function getCalcedDimensionHeight(): float
    {
        return $this->calcedDimensionHeight;
    }

    public function setPositionMode(int $positionMode): void
    {
        $this->positionMode = $positionMode;
    }

    public function setPositionX(float $x): void
    {
        $this->positionX = $x;
        $this->positionSetX = true;
    }

    public function setCalcedPositionX(float $x): void
    {
        $this->calcedPositionX = $x;
    }

    public function setCalcedPositionY(float $y): void
    {
        $this->calcedPositionY = $y;
    }

    public function setPositionY(float $y): void
    {
        $this->positionY = $y;
        $this->positionSetY = true;
    }

    public function setPosition(float $x, float $y): void
    {
        $this->positionX = $x;
        $this->positionY = $y;
        $this->positionSetX = true;
        $this->positionSetY = true;
    }

    public function setDimention(float $width, float $height): void
    {
        $this->dimensionWidth = $width;
        $this->dimensionHeight = $height;
    }

    public function setBounds(float $x, float $y, float $width, float $height): void
    {
        $this->positionX = $x;
        $this->positionY = $y;
        $this->dimensionWidth = $width;
        $this->dimensionHeight = $height;
        $this->positionSetX = true;
        $this->positionSetY = true;
    }

    public function setDimensionWidth(float $width): void
    {
        $this->dimensionWidth = $width;
    }

    public function setCalcedDimensionWidth(float $width): void
    {
        $this->calcedDimensionWidth = $width;
    }

    public function setCalcedDimensionHeight(float $height): void
    {
        $this->calcedDimensionHeight = $height;
    }

    public function calcRenderPosition(Pdf $pdf)
    {
        if ($this->positionSetX && $this->positionSetY) {
            $pdf->SetXY($this->positionX, $this->positionY);
        } elseif ($this->positionSetX) {
            $pdf->SetX($this->positionX);
        } elseif ($this->positionSetY) {
            $pdf->SetY($this->positionY);
        }
    }


    public function addComponent(ComponentInterface $component): void
    {
        $this->components[] = $component;
    }
}
