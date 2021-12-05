<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;
use RobinTheHood\Tfpdf\Tfpdf;

class DecoratorCanvas implements ContainerRendererCanvasInterface
{
    /**
     * @var Pdf $pdf;
     */
    private $pdf = null;

    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function setColor(float $r, float $g, float $b, float $alpha = 1): void
    {
    }

    public function drawLine(float $x1, float $y1, float $x2, float $y2): void
    {
        //$this->pdf->SetDrawColor($color['r'], $color['g'], $color['b']);
        $this->pdf->SetDrawColor(255, 0, 0);
        $this->pdf->Line($x1, $y1, $x2, $y2);
    }

    // Cant rename setFontSizeToDo() -> setFontSize() in Pdf
    public function setFontSizeToDo(float $size): void
    {
    }

    // Cant rename setFontToDo() -> setFont() in Pdf
    public function setFontToDo(string $fontFamily, string $fontStyle, float $fontSize): void
    {
    }

    public function drawText(string $text, float $x, float $y, float $width, float $height): void
    {
        //$this->pdf->SetFont($fontFamily, $fontStyle, $fontSize);
        $this->pdf->SetXY($x, $y);
        $this->pdf->Cell($width, $height, $text, Pdf::CELL_BORDER_NONE, Pdf::CELL_NEW_LINE_BELOW);
    }

    public function drawImage(string $imagePath, float $x, float $y, float $width, float $height): void
    {
    }
}
