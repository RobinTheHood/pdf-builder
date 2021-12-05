<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container\Interfaces;

interface ContainerRendererCanvasInterface
{
    public function setColor(float $r, float $g, float $b, float $alpha = 1): void;
    public function drawLine(float $x1, float $y1, float $x2, float $y2): void;

    // Cant rename setFontSizeToDo() -> setFontSize() in Pdf
    public function setFontSizeToDo(float $size): void;

    // Cant rename setFontToDo() -> setFont() in Pdf
    public function setFontToDo(string $fontFamily, string $fontStyle, float $fontSize): void;

    public function drawText(string $text, float $x, float $y, float $width, float $height): void;

    public function drawImage(string $imagePath, float $x, float $y, float $width, float $height): void;
}
