<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class Image implements ComponentInterface
{
    private const SIZE_X = 0;
    private $posisitonX = 0;
    private $posistionY = 0;
    private $width = 0;
    private $imagePath = '';

    public function __construct(string $path)
    {
        $this->imagePath = $path;
    }

    public function setPositionX(float $positionX): void
    {
        $this->posisitonX = $positionX;
    }

    public function setPositionY(float $posistionY): void
    {
        $this->posistionY = $posistionY;
    }

    public function setWidth(float $width): void
    {
        $this->width = $width;
    }

    public function render(Pdf $pdf): void
    {
        //$size = getimagesize($this->imagePath);
        //$scale = ($size[self::SIZE_X] / 300 * 25.4) * $this->scale;
        $pdf->Image($this->imagePath, $this->posisitonX, $this->posistionY, $this->width);
    }
}
