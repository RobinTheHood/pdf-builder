<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements\Interfaces;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

interface ComponentInterface
{
    public function render(Pdf $pdf);
}
