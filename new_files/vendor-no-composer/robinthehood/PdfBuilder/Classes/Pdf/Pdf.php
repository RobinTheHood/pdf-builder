<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;
use RobinTheHood\Tfpdf\Tfpdf;

class Pdf extends Tfpdf implements ContainerRendererCanvasInterface
{
    public const PAGE_DIN_A4_HEIGHT = 297; // Unit: mm;

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

    public $pageMapper = null;
    public $drawBuffer = null;

    public function __construct()
    {
        parent::__construct('P', 'mm', 'A4');
        $this->pageMapper = new PageMapper($this);
        $this->drawBuffer = new DrawBuffer($this);
    }

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

    public function setColor(float $r, float $g, float $b, float $alpha = 1): void
    {
        $this->drawBuffer->setColor((int) $r, (int) $g, (int) $b);
        //$this->SetDrawColor((int) $r, (int) $g, (int) $b);
    }

    }

    public function drawText(string $text, float $x, float $y, float $width, float $height): void
    {
        $newY = $this->pageMapper->mapYOnPage($y, $height);
        $relativePageNo = $newY['relativPageNo'];
        $this->drawBuffer->addDrawText($relativePageNo, $text, $x, $newY['yOnPage'], $width, $height);
        return;

        $newY = $this->pageMapper->mapYOnPage($y, $height);
        $this->pageMapper->doPageBreak($newY);

        $this->SetXY($x, $newY['yOnPage']);
        $this->Cell($width, $height, $text, self::CELL_BORDER_NONE, self::CELL_NEW_LINE_BELOW);
    }

    public function drawLine(float $x1, float $y1, float $x2, float $y2): void
    {
        $pageLineSplitter = new PageLineSplitter();
        $lines = $pageLineSplitter->cutLineNew($x1, $y1, $x2, $y2, $this->pageMapper);
        foreach ($lines as $line) {
            $y1OnPage = $this->pageMapper->yOnPage($line['y1'], $line['page']);
            $y2OnPage = $this->pageMapper->yOnPage($line['y2'], $line['page']);
            $this->drawBuffer->drawLine($line['page'], $line['x1'], $y1OnPage, $line['x2'], $y2OnPage);
        }

        return;

        // foreach ($lines as $line) {
        //     $this->SetDrawColor(0, 255 * ($line['page'] % 2), 255 * (($line['page'] + 1) % 2));
        //     $this->Line($line['x1'], $line['y1'] + ($line['page'] - 2) * 20, $line['x1'], $line['y2'] + ($line['page'] - 2) * 20);
        // }

        // $this->Line($x1, $y1, $x2, $y2);

        // return;
        $height = $y2 - $y1;
        $newY1 = $this->pageMapper->mapYOnPage($y1);

        if ($newY1['relativPageNo'] != $this->pageMapper->getRelativPageNo()) {
            return;
        }

        $this->Line($x1, $newY1['yOnPage'], $x2, $newY1['yOnPage'] + $height);
    }
}
