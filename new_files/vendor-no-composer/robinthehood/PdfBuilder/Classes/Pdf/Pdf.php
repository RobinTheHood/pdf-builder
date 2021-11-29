<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

use RobinTheHood\Tfpdf\Tfpdf;

class Pdf extends Tfpdf
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
}
