<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;
use RobinTheHood\Tfpdf\Tfpdf;

class Pdf extends Tfpdf implements ContainerRendererCanvasInterface
{
    public const POINTS_PER_MM = 72 / 25.4;

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

    private function cutLine(float $x1, float $y1, float $x2, float $y2, float $pageSize): array
    {
        $lines = [];

        $pageStart = (int) ($y1 / $pageSize);
        $pageEnd = (int) ($y2 / $pageSize);
        $pages = $pageEnd - $pageStart + 1;

        $deltaX = $x2 - $x1;
        $deltaY = $y2 - $y1;

        $cutLinePrevY = $y1;
        $yy2 = $y1;
        $xx2 = $x1;

        if ($y1 == $y2) {
            return [[
                'x1' => $x1,
                'y1' => $y1,
                'x2' => $x2,
                'y2' => $y2,
                'page' => $pageStart + 1,
            ]];
        }

        for ($deltaPage = 1; $deltaPage <= $pages; $deltaPage++) {
            $page = $pageStart + $deltaPage;
            if ($deltaPage < $pages) {
                $cutLineY = $pageSize * $page;
            } else {
                $cutLineY = $y2;
            }
            $dY = $cutLineY - $cutLinePrevY;
            $cutLinePrevY = $cutLineY;

            $yy1 = $yy2;
            $yy2 = $yy2 + $dY;

            $dX = $dY * ($deltaX / $deltaY);
            $xx1 = $xx2;
            $xx2 = $xx2 + $dX;

            $lines[] = [
                'x1' => $xx1,
                'y1' => $yy1,
                'x2' => $xx2,
                'y2' => $yy2,
                'page' => $page,
            ];
        }

        return $lines;
    }

    private $missedLines = [];

    public function drawLine(float $x1, float $y1, float $x2, float $y2): void
    {
        $y1 = $this->getYPositionOnPage($y1);
        $y2 = $this->getYPositionOnPage($y2);
        $this->Line($x1, $y1, $x2, $y2);
    }

    public function drawLineNew(float $x1, float $y1, float $x2, float $y2): void
    {
        $drawSize = 297 - 35;
        $pageSize = $drawSize;
        $lines = $this->cutLine($x1, $y1, $x2, $y2, $pageSize);
        $lines = array_merge($this->missedLines, $lines);
        $this->missedLines = [];
        foreach ($lines as $line) {
            if ($line['page'] != $this->PageNo()) {
                $this->missedLines[] = $line;
                continue;
            }
            // $newY1 = $line['y1'] % ($drawSize+1);
            // $newY2 = $line['y2'] % ($drawSize+1);

            $newY1 = $this->getYPositionOnPage($line['y1']);
            $newY2 = $this->getYPositionOnPage($line['y2']);

            $this->SetDrawColor(0, 255 * ($line['page'] % 2), 255 * (($line['page'] + 1) % 2));
            $this->Line($line['x1'], $newY1, $line['x2'], $newY2);
        }
        return;

        $y1 = $this->getYPositionOnPage($y1);
        $y2 = $this->getYPositionOnPage($y2);
        $this->Line($x1, $y1, $x2, $y2);
    }

    private $lastOffset = 0;
    private $lastPageNo = 1;
    public function getYPositionOnPage(float $y): float
    {
        $drawSize = 297 - 35;
        if ($this->lastPageNo < $this->PageNo()) {
            $this->lastOffset = $y - $this->GetY();
            $this->lastPageNo = $this->PageNo();
        }
        return $y - $this->lastOffset;
    }

    public function resetOffset()
    {
        $this->lastOffset = 0;
        $this->lastPageNo = $this->PageNo();
    }
}
