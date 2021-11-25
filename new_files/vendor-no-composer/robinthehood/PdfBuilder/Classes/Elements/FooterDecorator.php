<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\DecoratorInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class FooterDecorator implements DecoratorInterface
{
    private $posY = -35;
    private $components = [];

    public function addComponent(ComponentInterface $component): void
    {
        $this->components[] = $component;
    }

    public function render(Pdf $pdf): void
    {
        $pdf->SetY($this->posY);
        foreach ($this->components as $component) {
            $component->render($pdf);
        }
    }
}
