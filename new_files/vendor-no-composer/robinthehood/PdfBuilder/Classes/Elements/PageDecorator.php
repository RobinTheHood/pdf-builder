<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\DecoratorInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class PageDecorator implements DecoratorInterface
{
    public function addComponent(ComponentInterface $component): void
    {
        $this->components[] = $component;
    }

    public function render(Pdf $pdf): void
    {
        foreach ($this->components as $component) {
            $component->render($pdf);
        }
    }
}
