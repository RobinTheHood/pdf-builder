<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Pdf\StringSplitter;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class TextArea implements ComponentInterface
{
    private $positionX = 0;
    private $positionY = 0;
    private $dimensionWidth = 0;
    private $dimensionHeight = 0;

    // Text and Font Propertys
    private $text = '';
    private $fontFamily = 'DejaVu';
    private $fontSize = 8;
    private $lineHeight = 8;

    public function setPosition(float $x, float $y): void
    {
        $this->positionX = $x;
        $this->positionY = $y;
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
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setLineHeight(float $lineHeight): void
    {
        $this->lineHeight = $lineHeight;
    }

    public function setFontSize(float $fontSize): void
    {
        $this->fontSize = $fontSize;
    }

    public function render(Pdf $pdf): void
    {
        $pdf->SetFont($this->fontFamily, '', $this->fontSize);
        $pdf->SetXY($this->positionX, $this->positionY);
        $lines = StringSplitter::splitByLength($pdf, $this->text, $this->dimensionWidth);
        foreach ($lines as $line) {
            $pdf->Cell($this->dimensionWidth, $this->lineHeight, $line, PDF::CELL_BORDER_NONE, PDF::CELL_NEW_LINE_BELOW);
        }
    }
}
