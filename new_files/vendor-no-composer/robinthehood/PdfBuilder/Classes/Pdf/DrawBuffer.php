<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

class DrawBuffer
{

    private $buffer = [];
    private $pdf = null;

    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function reset()
    {
        $this->buffer = [];
    }

    public function addDrawText(int $pageNo, string $text, float $x, float $y, float $width, float $height): void
    {
        $this->buffer[$pageNo][] = [
            'function' => 'drawText',
            'text' => $text,
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height
        ];
    }

    public function addDrawLine(int $pageNo, float $x1, float $y1, float $x2, float $y2): void
    {
        $this->buffer[$pageNo][] = [
            'function' => 'drawLine',
            'x1' => $x1,
            'y1' => $y1,
            'x2' => $x2,
            'y2' => $y2
        ];
    }

    public function renderBuffer()
    {
        //TODO: Buffer nach $relativPageNo sortieren
        foreach ($this->buffer as $relativPageNo => $functions) {
            foreach ($functions as $function) {
                if ($function['function'] == 'drawText') {
                    $this->drawText(
                        $function['text'],
                        $function['x'],
                        $function['y'],
                        $function['width'],
                        $function['height']
                    );
                } elseif ($function['function'] == 'drawLine') {
                    $this->drawLine(
                        $function['x1'],
                        $function['y1'],
                        $function['x2'],
                        $function['y2'],
                    );
                }
            }
            $this->pdf->addPage();
            $this->pdf->SetXY(0, 0);
        }
    }

    private function drawText(string $text, float $x, float $y, float $width, float $height): void
    {
        $this->pdf->SetXY($x, $y);
        $this->pdf->Cell($width, $height, $text, Pdf::CELL_BORDER_NONE, Pdf::CELL_NEW_LINE_BELOW);
    }

    private function drawLine(float $x1, float $y1, float $x2, float $y2): void
    {
        $this->pdf->Line($x1, $y1, $x2, $y2);
    }
}
