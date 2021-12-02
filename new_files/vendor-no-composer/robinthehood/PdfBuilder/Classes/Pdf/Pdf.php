<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;
use RobinTheHood\Tfpdf\Tfpdf;

class Pdf extends Tfpdf implements ContainerRendererCanvasInterface
{
    public const CELL_NEW_LINE_OFF = 0;
    public const CELL_NEW_LINE = 1;
    public const CELL_NEW_LINE_BELOW = 2;
    public const CELL_FILL = 1;

    public const CELL_ALIGN_LEFT = 'L';
    public const CELL_ALIGN_CENTER = 'C';
    public const CELL_ALIGN_RIGHT = 'R';

    public const CELL_BORDER_NONE = 0;
    public const CELL_BORDER_ON = 1;
    public const CELL_BORDER_TOP = 'T';

    public const FONT_WEIGHT_NORMAL = '';
    public const FONT_WEIGHT_BOLD = 'B';

    private $pageFunction;
    private $headerFunction;
    private $footerFunction;

    private $storedPositionX = 0;
    private $storedPositionY = 0;

    public function setPageFunction($callable)
    {
        $this->pageFunction = $callable;
    }

    public function setHeaderFunction($callable)
    {
        $this->headerFunction = $callable;
    }

    public function setFooterFunction($callable)
    {
        $this->footerFunction = $callable;
    }

    public function addPage($orientation = '', $size = ''): void
    {
        parent::addPage($orientation, $size);

        if (\is_callable($this->pageFunction)) {
            call_user_func($this->pageFunction, $this);
        }
    }

    public function header()
    {
        if (\is_callable($this->headerFunction)) {
            call_user_func($this->headerFunction, $this);
        }
    }

    public function footer()
    {
        if (\is_callable($this->footerFunction)) {
            call_user_func($this->footerFunction, $this);
        }
    }

    public function getPosition(): array
    {
        return [
            'x' => $this->GetX(),
            'y' => $this->GetY()
        ];
    }

    public function setPosition(array $position): void
    {
        $this->SetXY($position['x'], $position['y']);
    }

    public function setColor(float $r, float $g, float $b, float $alpha = 1): void
    {
        $this->SetDrawColor((int) $r, (int) $g, (int) $b);
    }

    public function drawLine(float $x1, float $y1, float $x2, float $y2): void
    {
        $this->Line($x1, $y1, $x2, $y2);
    }
}
