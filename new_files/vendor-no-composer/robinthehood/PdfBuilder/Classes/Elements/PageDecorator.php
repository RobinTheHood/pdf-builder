<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\DecoratorInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\ComponentChildTrait;

class PageDecorator extends Container implements DecoratorInterface
{
    use ComponentChildTrait;

    // Todo: remove
    public function render(Pdf $pdf): void
    {
        foreach ($this->childComponents as $childComponent) {
            $childComponent->render($pdf);
        }
    }
}
