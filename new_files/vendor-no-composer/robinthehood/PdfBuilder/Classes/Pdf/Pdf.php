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
    public const CELL_BORDER_TOP = 'T';

    private $headerFunction;
    private $footerFunction;

    public function setHeaderFunction($callable)
    {
        $this->headerFunction = $callable;
    }

    public function setFooterFunction($callable)
    {
        $this->footerFunction = $callable;
    }

    public function Header()
    {
        if (\is_callable($this->headerFunction)) {
            call_user_func($this->headerFunction, $this);
        }
    }

    public function Footer()
    {
        if (\is_callable($this->footerFunction)) {
            call_user_func($this->footerFunction, $this);
        }
    }
}
