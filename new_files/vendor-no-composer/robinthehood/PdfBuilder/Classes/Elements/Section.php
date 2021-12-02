<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\DecoratorInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\ComponentChildTrait;
use RobinTheHood\PdfBuilder\Classes\Pdf\ContainerPdfRenderer;

class Section extends Container
{
    use ComponentChildTrait;

    private $pageDecorator;
    private $headerDecorator;
    private $footerDecorator;

    private $pageMode = DecoratorInterface::DECORATION_MODE_ALWAYS;
    private $headerMode = DecoratorInterface::DECORATION_MODE_ALWAYS;
    private $footerMode = DecoratorInterface::DECORATION_MODE_ALWAYS;

    private $headerDrawCount = 0;
    private $footerDrawCount = 0;

    protected $fontFamily = 'DejaVu';

    public function setPageDecorator(DecoratorInterface $pageDecorator)
    {
        $this->pageDecorator = $pageDecorator;
    }

    public function setHeaderDecorator(DecoratorInterface $headerDecorator): void
    {
        $this->headerDecorator = $headerDecorator;
    }

    public function setFooterDecorator(DecoratorInterface $footerDecorator): void
    {
        $this->footerDecorator = $footerDecorator;
    }

    public function calcComponents()
    {
        foreach ($this->components as $component) {
            $component->setCalcedPositionX(0 + $component->getPositionX());
            $component->setCalcedPositionY(0 + $component->getPositionY());
        }

        foreach ($this->components as $component) {
            $component->calcComponents();
        }
    }

    public function render(Pdf $pdf, Section $lastFooterSection): void
    {
        $pdf->setPageFunction([$this, 'renderPageDecorator']);
        $pdf->setHeaderFunction([$this, 'renderHeaderDecorator']);
        $pdf->setFooterFunction([$lastFooterSection, 'renderFooterDecorator']);
        $pdf->addPage();
        $pdf->setFooterFunction([$this, 'renderFooterDecorator']);
        $this->renderComponents($pdf);
    }

    public function renderPageDecorator(Pdf $pdf): void
    {
        $this->pageDrawCount++;

        if ($this->pageMode == DecoratorInterface::DECORATION_MODE_NEVER) {
            return;
        } elseif ($this->pageMode == DecoratorInterface::DECORATION_MODE_NOT_FIRST && $this->pageDrawCount <= 1) {
            return;
        }

        if ($this->pageDecorator) {
            $this->pageDecorator->render($pdf);
        }
    }

    public function renderHeaderDecorator(Pdf $pdf): void
    {
        $this->headerDrawCount++;

        if ($this->headerMode == DecoratorInterface::DECORATION_MODE_NEVER) {
            return;
        } elseif ($this->headerMode == DecoratorInterface::DECORATION_MODE_NOT_FIRST && $this->headerDrawCount <= 1) {
            return;
        }

        if ($this->headerDecorator) {
            $this->headerDecorator->render($pdf);
        }
    }

    public function renderFooterDecorator(Pdf $pdf): void
    {
        $this->footerDrawCount++;

        if ($this->footerMode == DecoratorInterface::DECORATION_MODE_NEVER) {
            return;
        } elseif ($this->footerMode == DecoratorInterface::DECORATION_MODE_NOT_FIRST && $this->footerDrawCount <= 1) {
            return;
        }

        if ($this->footerDecorator) {
            $this->footerDecorator->render($pdf);
        }
    }

    private function renderComponents(Pdf $pdf): void
    {
        // New Render Container
        $this->calcAll();
        $canvas = $pdf;

        $renderer = $this->getContainerRenderer();
        $renderer->render($canvas, $this);
        //return;

        // Render Old
        foreach ($this->childComponents as $childComponent) {
            $childComponent->render($pdf);
        }
    }
}
