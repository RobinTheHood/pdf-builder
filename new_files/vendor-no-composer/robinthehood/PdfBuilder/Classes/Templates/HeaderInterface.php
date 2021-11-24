<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Templates;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

interface HeaderInterface
{
    public function render(Pdf $pdf);
}
