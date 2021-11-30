<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Pdf\StringSplitter;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class TextArea implements ComponentInterface
{
    use ComponentTrait;

    public const VERTICAL_ALIGN_TOP = 0;
    public const VERTICAL_ALIGN_BOTTOM = 2;
    public const OVERFLOW_Y_VISIBLE = 1;
    public const OVERFLOW_Y_HIDDEN = 0;

    // private $positionX = 0;
    // private $positionY = 0;
    // private $dimensionWidth = 0;
    // private $dimensionHeight = 0;
    private $verticalAlign = self::VERTICAL_ALIGN_TOP;

    private $overflowY = self::OVERFLOW_Y_VISIBLE;

    // Text and Font Propertys
    private $text = '';
    private $fontFamily = 'DejaVu';
    private $fontSize = 8;
    private $lineHeight = 8;
    private $fontWeight = PDF::FONT_WEIGHT_NORMAL;

    // public function setPosition(float $x, float $y): void
    // {
    //     $this->positionX = $x;
    //     $this->positionY = $y;
    // }

    // public function setDimention(float $width, float $height): void
    // {
    //     $this->dimensionWidth = $width;
    //     $this->dimensionHeight = $height;
    // }

    // public function setBounds(float $x, float $y, float $width, float $height): void
    // {
    //     $this->positionX = $x;
    //     $this->positionY = $y;
    //     $this->dimensionWidth = $width;
    //     $this->dimensionHeight = $height;
    // }

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

    public function setFontWeight(string $fontWeight): void
    {
        $this->fontWeight = $fontWeight;
    }

    public function setVerticalAlign(int $verticalAlign): void
    {
        $this->verticalAlign = $verticalAlign;
    }

    public function setOverflowY(int $value): void
    {
        $this->overflowY = $value;
    }

    public function render(Pdf $pdf): void
    {
        if ($this->verticalAlign == self::VERTICAL_ALIGN_TOP) {
            $maxPosY = $this->positionY + $this->dimensionHeight;

            $pdf->SetFont($this->fontFamily, $this->fontWeight, $this->fontSize);
            $this->calcRenderPosition($pdf);
            $startPosition = $pdf->getPosition();

            //$pdf->SetXY($this->positionX, $this->positionY);
            $lines = StringSplitter::splitByLength($pdf, $this->text, $this->dimensionWidth);
            foreach ($lines as $line) {
                // Do not draw next text line if overflow
                if ($this->overflowY == self::OVERFLOW_Y_HIDDEN && $pdf->GetY() >= $maxPosY) {
                    break;
                }
                $pdf->Cell($this->dimensionWidth, $this->lineHeight, $line, PDF::CELL_BORDER_NONE, PDF::CELL_NEW_LINE_BELOW);
            }
        } elseif ($this->verticalAlign == self::VERTICAL_ALIGN_BOTTOM) {
            $pdf->SetFont($this->fontFamily, $this->fontWeight, $this->fontSize);
            $lines = StringSplitter::splitByLength($pdf, $this->text, $this->dimensionWidth);
            $lines = array_reverse($lines);
            $lineNumber = 0;
            foreach ($lines as $line) {
                $lineNumber++;
                $y = $this->positionY + $this->dimensionHeight - ($this->lineHeight * $lineNumber);
                $pdf->SetXY($this->positionX, $y);
                $pdf->Cell($this->dimensionWidth, $this->lineHeight, $line, PDF::CELL_BORDER_NONE, PDF::CELL_NEW_LINE_OFF);
            }
            $startPosition = [
                'x' => $this->positionX,
                'y' => $this->positionY
            ];
        }
        $endPosition = $pdf->getPosition();

        // Hole Component Area
        $pdf->SetDrawColor(0, 255, 0);
        $pdf->Rect($startPosition['x'], $startPosition['y'], $this->dimensionWidth, $this->dimensionHeight);
    }

    private function renderBounds(Pdf $pdf): void
    {
        // Hole Component Area
        // $pdf->SetDrawColor(0, 0, 255);
        // $pdf->Rect($startPosition['x'], $startPosition['y'], $this->dimensionWidth, $endPosition['y'] - $startPosition['y']);

        // $pdf->SetDrawColor(0, 255, 0);
        // $pdf->SetXY($this->positionX, $this->positionY);
        // $pdf->Cell($this->dimensionWidth, $this->dimensionHeight, '', PDF::CELL_BORDER_ON);
    }
}
