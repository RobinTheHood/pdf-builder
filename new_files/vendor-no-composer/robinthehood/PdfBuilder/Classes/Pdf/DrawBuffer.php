<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

class DrawBuffer
{

    private $buffer = [];
    private $pdf = null;
    private $drawColor = [];
    private $fontFamily = 'DejaVu';
    private $fontStyle = '';
    private $fontSize = 10;

    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function reset()
    {
        $this->buffer = [];
    }

    public function setColor($r, $g, $b): void
    {
        $this->drawColor = [
            'r' => $r,
            'g' => $g,
            'b' => $b,
        ];
    }

    public function setFontSize(float $fontSize): void
    {
        $this->fontSize = $fontSize;
    }

    public function setFont(string $fontFamily, string $fontStyle, float $fontSize): void
    {
        $this->fontFamily = $fontFamily;
        $this->fontStyle = $fontStyle;
        $this->fontSize = $fontSize;
    }

    public function drawText(int $pageNo, string $text, float $x, float $y, float $width, float $height): void
    {
        $this->buffer[$pageNo][] = [
            'function' => 'drawText',
            'text' => $text,
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
            'fontFamily' => $this->fontFamily,
            'fontStyle' => $this->fontStyle,
            'fontSize' => $this->fontSize
        ];
    }

    public function drawLine(int $pageNo, float $x1, float $y1, float $x2, float $y2): void
    {
        $this->buffer[$pageNo][] = [
            'function' => 'drawLine',
            'x1' => $x1,
            'y1' => $y1,
            'x2' => $x2,
            'y2' => $y2,
            'color' => $this->drawColor
        ];
    }

    public function drawImage(int $pageNo, string $imagePath, float $x, float $y, float $width, float $height): void
    {
        $this->buffer[$pageNo][] = [
            'function' => 'drawImage',
            'imagePath' => $imagePath,
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
        ];
    }

    public function renderBuffer()
    {
        //TODO: Buffer nach $relativPageNo sortieren
        foreach ($this->buffer as $relativPageNo => $functions) {
            foreach ($functions as $function) {
                if ($function['function'] == 'drawText') {
                    $this->renderDrawText(
                        $function['text'],
                        $function['x'],
                        $function['y'],
                        $function['width'],
                        $function['height'],
                        $function['fontFamily'],
                        $function['fontStyle'],
                        $function['fontSize']
                    );
                } elseif ($function['function'] == 'drawLine') {
                    $this->renderDrawLine(
                        $function['x1'],
                        $function['y1'],
                        $function['x2'],
                        $function['y2'],
                        $function['color']
                    );
                } elseif ($function['function'] == 'drawImage') {
                    $this->renderDrawImage(
                        $function['imagePath'],
                        $function['x'],
                        $function['y'],
                        $function['width'],
                        $function['height']
                    );
                }
            }
            $this->pdf->addPage();
            $this->pdf->SetXY(0, 0);
        }
    }

    private function renderDrawText(string $text, float $x, float $y, float $width, float $height, string $fontFamily, string $fontStyle, float $fontSize): void
    {
        $this->pdf->SetFont($fontFamily, $fontStyle, $fontSize);
        $this->pdf->SetXY($x, $y);
        $this->pdf->Cell($width, $height, $text, Pdf::CELL_BORDER_NONE, Pdf::CELL_NEW_LINE_BELOW);
    }

    private function renderDrawLine(float $x1, float $y1, float $x2, float $y2, array $color): void
    {
        $this->pdf->SetDrawColor($color['r'], $color['g'], $color['b']);
        $this->pdf->Line($x1, $y1, $x2, $y2);
    }

    private function renderDrawImage(string $imagePath, float $x, float $y, float $width, float $height): void
    {
        $this->pdf->Image($imagePath, $x, $y, $width, $height);
    }
}
