<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements\Interfaces;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

interface ComponentInterface
{
    public const POSITION_MODE_RELATIVE = 0;
    public const POSITION_MODE_ABSOLUTE = 1;

    public function render(Pdf $pdf);
}
