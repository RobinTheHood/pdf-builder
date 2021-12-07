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

    /**
     * @var array $color
     */
    private $color = [];

    /**
     * @var string $fontFamily
     */
    private $fontFamily;

    /**
     * @var string $fontStyle
     */
    private $fontStyle;

    /**
     * @var float $fontSize
     */
    private $fontSize;

    /**
     * @var float $lineWidth
     */
    private $lineWidth = 0.2;

    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
        $this->color = ['r' => 0, 'g' => 0, 'b' => 0];
    }

    public function setColor(float $r, float $g, float $b, float $alpha = 1): void
    {
        $this->color = ['r' => $r, 'g' => $g, 'b' => $b];
    }

    public function setLineWidthToDo(float $lineWidth): void
    {
        $this->lineWidth = $lineWidth;
    }

    public function drawLine(float $x1, float $y1, float $x2, float $y2): void
    {
        $this->pdf->SetLineWidth($this->lineWidth);
        $this->pdf->SetDrawColor($this->color['r'], $this->color['g'], $this->color['b']);
        $this->pdf->Line($x1, $y1, $x2, $y2);
    }

    // Cant rename setFontSizeToDo() -> setFontSize() in Pdf
    public function setFontSizeToDo(float $size): void
    {
    }

    // Cant rename setFontToDo() -> setFont() in Pdf
    public function setFontToDo(string $fontFamily, string $fontStyle, float $fontSize): void
    {
        $this->fontFamily = $fontFamily;
        $this->fontStyle = $fontStyle;
        $this->fontSize = $fontSize;
    }

    public function drawText(
        string $text,
        float $x,
        float $y,
        float $width,
        float $height,
        string $alignment = Pdf::CELL_ALIGN_LEFT
    ): void {
        $this->pdf->SetFont($this->fontFamily, $this->fontStyle, $this->fontSize);
        $this->pdf->SetXY($x, $y);
        $this->pdf->Cell($width, $height, $text, Pdf::CELL_BORDER_NONE, Pdf::CELL_NEW_LINE_BELOW, $alignment);
    }

    public function drawImage(string $imagePath, float $x, float $y, float $width, float $height): void
    {
    }
}
