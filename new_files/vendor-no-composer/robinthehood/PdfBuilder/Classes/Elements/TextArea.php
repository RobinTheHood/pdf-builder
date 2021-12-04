<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Pdf\StringSplitter;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\ComponentTrait;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\TextTrait;

class TextArea extends Container implements ComponentInterface
{
    use ComponentTrait;
    use TextTrait;

    public const VERTICAL_ALIGN_TOP = 0;
    public const VERTICAL_ALIGN_BOTTOM = 2;
    public const OVERFLOW_Y_VISIBLE = 1;
    public const OVERFLOW_Y_HIDDEN = 0;

    private $verticalAlign = self::VERTICAL_ALIGN_TOP;

    private $overflowY = self::OVERFLOW_Y_VISIBLE;

    public function __construct()
    {
        parent::__construct();
        $this->setContainerRenderer(new TextAreaRenderer());
    }

    public function setVerticalAlign(int $verticalAlign): void
    {
        $this->verticalAlign = $verticalAlign;
    }

    public function setOverflowY(int $value): void
    {
        $this->overflowY = $value;
    }

    protected function calcSetHeight(): void
    {
        if ($this->containerBox->height->isSet()) {
            return;
        }

        $lineHeight = $this->getLineHeight();
        if ($lineHeight === null) {
            $lineHeight = $this->getFontHeight();
        }

        $contentWidth = $this->getCalcedContainer()->containerBox->getContentBox()['width'];
        $lines = $this->splitTextInLines($contentWidth);
        $height = $lineHeight * count($lines);
        $this->getCalcedContainer()->containerBox->height->setValue($height);
    }

    public function calcComponents()
    {
        foreach ($this->childComponents as $childComponent) {
            $childComponent->setCalcedPositionX($this->calcedPositionX + $childComponent->getPositionX());
            $childComponent->setCalcedPositionY($this->calcedPositionX + $childComponent->getPositionY());
        }

        foreach ($this->childComponents as $childComponent) {
            $childComponent->calcComponents();
        }
    }

    public function render(Pdf $pdf): void
    {
        if ($this->verticalAlign == self::VERTICAL_ALIGN_TOP) {
            $maxPosY = $this->positionY + $this->dimensionHeight;

            $pdf->SetFont($this->fontFamily, $this->fontWeight, $this->fontSize);
            //$this->calcRenderPosition($pdf);
            $pdf->SetXY($this->calcedPositionX, $this->calcedPositionY);
            $startPosition = $pdf->getPosition();
            $lines = StringSplitter::splitByLength($pdf, $this->text, $this->calcedDimensionWidth);
            foreach ($lines as $line) {
                // Do not draw next text line if overflow
                if ($this->overflowY == self::OVERFLOW_Y_HIDDEN && $pdf->GetY() >= $maxPosY) {
                    break;
                }
                $pdf->Cell($this->calcedDimensionWidth, $this->lineHeight, $line, PDF::CELL_BORDER_NONE, PDF::CELL_NEW_LINE_BELOW);
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
        $pdf->Rect($startPosition['x'], $startPosition['y'], $this->calcedDimensionWidth, $this->calcedDimensionHeight);
    }

    public function calcBefore(Pdf $pdf): void
    {
        $lines = StringSplitter::splitByLength($pdf, $this->text, $this->dimensionWidth);
        $height = count($lines) * $this->lineHeight;
        $this->setCalcedDimensionHeight($height);
        $this->setCalcedDimensionWidth($this->dimensionWidth);
    }
}
