<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class FoldMark implements ComponentInterface
{
    public function render(Pdf $pdf): void
    {
        $pdf->Line(5, 297.0 / 2.0, 8, 297.0 / 2.0);
    }
}
