<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\DecoratorInterface;
use RobinTheHood\PdfBuilder\Classes\Pdf\DecoratorCanvas;
use RobinTheHood\PdfBuilder\Classes\Pdf\PageMarginTrait;

class Section extends Container
{
    use PageMarginTrait;

    /**
     * @var PageDecorator $pageDecorator
     */
    private $pageDecorator;

    /**
     * @var HeaderDecorator $headerDecorator
     */
    private $headerDecorator;

    /**
     * @var FeaderDecorator $footerDecorator
     */
    private $footerDecorator;

    /**
     * @var int $pageMode
     */
    private $pageMode = DecoratorInterface::DECORATION_MODE_ALWAYS;

    /**
     * @var int $headerMode
     */
    private $headerMode = DecoratorInterface::DECORATION_MODE_ALWAYS;

    /**
     * @var int $footerMode
     */
    private $footerMode = DecoratorInterface::DECORATION_MODE_ALWAYS;

    /**
     * @var int $headerDrawCount
     */
    private $headerDrawCount = 0;

    /**
     * @var int $footerDrawCount
     */
    private $footerDrawCount = 0;

    /**
     * @var string $fontFamily
     */
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

    public function render(Pdf $pdf, Section $lastFooterSection): void
    {
        $pdf->setPageFunction([$this, 'renderPageDecorator']);
        $pdf->setHeaderFunction([$this, 'renderHeaderDecorator']);
        $pdf->setFooterFunction([$lastFooterSection, 'renderFooterDecorator']);
        $pdf->addPage();
        $pdf->setFooterFunction([$this, 'renderFooterDecorator']);
        $this->renderContainers($pdf);
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
            /**
             * @var Container $container
             */
            $container = $this->pageDecorator;

            $container->calcAll();
            $decoratorCanvas = new DecoratorCanvas($pdf);
            $renderer = $container->getContainerRenderer();
            $renderer->render($decoratorCanvas, $container);
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
            /**
             * @var Container $container
             */
            $container = $this->headerDecorator;

            $container->calcAll();
            $decoratorCanvas = new DecoratorCanvas($pdf);
            $renderer = $container->getContainerRenderer();
            $renderer->render($decoratorCanvas, $container);
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
            /**
             * @var Container $container
             */
            $container = $this->footerDecorator;

            $container->calcAll();
            $decoratorCanvas = new DecoratorCanvas($pdf);
            $renderer = $container->getContainerRenderer();
            $renderer->render($decoratorCanvas, $container);
        }
    }

    private function renderContainers(Pdf $pdf): void
    {
        $this->calcAll();
        $canvas = $pdf;
        $canvas->pageMapper->reset();
        $canvas->pageMapper->setDefaultPageMargin($this->defaultPageMargin['top'], $this->defaultPageMargin['bottom']);
        $canvas->pageMapper->setPageMargins($this->pageMargins);
        $canvas->drawBuffer->reset();

        $renderer = $this->getContainerRenderer();
        $renderer->render($canvas, $this);

        $canvas->drawBuffer->renderBuffer();
    }
}
