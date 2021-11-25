<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements\Interfaces;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

interface DecoratorInterface
{
    public const DECORATION_MODE_NEVER = 0;
    public const DECORATION_MODE_ALWAYS = 1;
    public const DECORATION_MODE_NOT_FIRST = 2;

    public function render(Pdf $pdf);
}
