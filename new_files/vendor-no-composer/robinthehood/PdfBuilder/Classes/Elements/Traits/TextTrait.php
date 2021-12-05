<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements\Traits;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Pdf\StringSplitter;

trait TextTrait
{
    private $text = '';
    private $fontFamily = 'DejaVu';
    private $fontSize = 8;
    private $lineHeight = null;
    private $fontWeight = Pdf::FONT_STYLE_NORMAL;

    public function getText(): string
    {
        return $this->text;
    }

    public function getLineHeight(): ?float
    {
        return $this->lineHeight;
    }

    public function getFontSize(): float
    {
        return $this->fontSize;
    }

    public function getFontWeight(): string
    {
        return $this->fontWeight;
    }

    public function getFontFamily(): string
    {
        return $this->fontFamily;
    }

    public function getFontHeight(): float
    {
        return $this->getFontSize() / Pdf::POINTS_PER_MM;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setLineHeight(?float $lineHeight): void
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

    public function splitTextInLines(float $maxWidth): array
    {
        $stringSplitter = StringSplitter::getStringSplitter();
        $lines = $stringSplitter->splitByLength(
            $this->text,
            $maxWidth,
            $this->fontFamily,
            $this->fontWeight,
            $this->fontSize
        );

        return $lines;
    }
}
