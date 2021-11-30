<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\DecoratorInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\ComponentChildTrait;

class FooterDecorator implements DecoratorInterface
{
    use ComponentChildTrait;

    private $posY = -35;

    public function render(Pdf $pdf): void
    {
        $pdf->SetY($this->posY);
        foreach ($this->childComponents as $childComponent) {
            $childComponent->render($pdf);
        }
    }
}
