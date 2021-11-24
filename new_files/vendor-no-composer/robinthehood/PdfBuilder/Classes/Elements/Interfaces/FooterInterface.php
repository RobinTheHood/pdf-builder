<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements\Interfaces;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

interface FooterInterface
{
    public function render(Pdf $pdf);
}
