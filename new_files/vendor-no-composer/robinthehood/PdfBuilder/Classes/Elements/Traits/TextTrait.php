<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements\Traits;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

trait TextTrait
{
    private $text = '';
    private $fontFamily = 'DejaVu';
    private $fontSize = 8;
    private $lineHeight = 8;
    private $fontWeight = PDF::FONT_WEIGHT_NORMAL;

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
}
