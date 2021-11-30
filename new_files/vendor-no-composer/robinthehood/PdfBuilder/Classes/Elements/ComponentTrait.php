<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

trait ComponentTrait
{
    private $positionX = 0;
    private $positionY = 0;
    private $dimensionWidth = 0;
    private $dimensionHeight = 0;

    private $positionMode = ComponentInterface::POSITION_MODE_RELATIVE;
    private $positionSetX = false;
    private $positionSetY = false;

    public function setPositionMode(int $positionMode): void
    {
        $this->positionMode = $positionMode;
    }

    public function setPositionX(float $x): void
    {
        $this->positionX = $x;
        $this->positionSetX = true;
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
}
