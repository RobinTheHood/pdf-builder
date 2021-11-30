<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\DecoratorInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\ComponentChildTrait;

class PageDecorator implements DecoratorInterface
{
    use ComponentChildTrait;

    public function render(Pdf $pdf): void
    {
        foreach ($this->childComponents as $childComponent) {
            $childComponent->render($pdf);
        }
    }
}
