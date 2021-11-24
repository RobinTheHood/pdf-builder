<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\FooterInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class Footer implements FooterInterface
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
