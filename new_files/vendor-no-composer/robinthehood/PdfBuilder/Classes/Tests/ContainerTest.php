<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Tests;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\ContainerPdfRenderer;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class ContainerTest
{
    private const DEFAULT_WIDTH = 210; // Unit: mm
    private const DEFAULT_HEIGHT = 297; // Unit: mm
    private $canvas;

    public function __construct()
    {
        $leftMargin = 20;
        $footerY = -25;
        $fontFamily = 'DejaVu';

        $pdf = new Pdf();
        $pdf->AddFont($fontFamily, '', 'DejaVuSansCondensed.ttf', true);
        $pdf->AddFont($fontFamily, 'B', 'DejaVuSansCondensed-Bold.ttf', true);

        $pdf->SetAutoPageBreak(true, abs($footerY) + 10);
        $pdf->SetCreator("PdfBuilder (c) 2021 Robin Wieschendorf");
        //$pdf->AliasNbPages();

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetDisplayMode('fullwidth');
        $pdf->SetTitle('Pdf Builder Test');
        //$pdf->SetLeftMargin($this->leftMargin);
        $pdf->addPage();

        $this->canvas = $pdf;
    }

    public function test1(): void
    {
        $baseContainer = new Container();
        $baseContainer->position = Container::POSITION_ABSOLUT;
        $baseContainer->containerBox->positionX->setValue(10);
        $baseContainer->containerBox->positionY->setValue(10);
        $baseContainer->containerBox->width->setValue(self::DEFAULT_WIDTH - 20);
        $baseContainer->containerBox->height->setValue(self:: DEFAULT_HEIGHT - 20);

        $container1 = new Container();
        //$container1->containerBox->width->setValue(20);
        //$container1->containerBox->height->setValue(20);
        $container1->containerBox->marginLeft->setValue(5);
        $container1->containerBox->marginRight->setValue(20);
        $container1->containerBox->marginTop->setValue(5);
        $container1->containerBox->marginBottom->setValue(3);
        $container1->containerBox->borderLeft->setValue(5);
        $container1->containerBox->borderRight->setValue(20);
        $container1->containerBox->borderTop->setValue(5);
        $container1->containerBox->borderBottom->setValue(3);

        $container11 = new Container();
        $container11->containerBox->width->setValue(80);
        $container11->containerBox->height->setValue(20);
        $container11->containerBox->marginTop->setValue(5);
        $container11->containerBox->marginBottom->setValue(5);
        $container12 = new Container();
        //$container12->containerBox->width->setValue(60);
        $container12->containerBox->height->setValue(20);
        $container12->containerBox->marginLeft->setValue(10);
        $container12->containerBox->marginTop->setValue(10);
        $container1->addChildContainer($container11);
        $container1->addChildContainer($container12);

        $container2 = new Container();
        $container2->containerBox->width->setValue(100);
        $container2->containerBox->height->setValue(20);

        $container3 = new Container();
        $container3->position = Container::POSITION_ABSOLUT;
        $container3->containerBox->positionX->setValue(10);
        $container3->containerBox->positionY->setValue(150);
        $container3->containerBox->width->setValue(140);
        //$container3->containerBox->height->setValue(20);
        $container31 = new Container();
        $container31->containerBox->width->setValue(120);
        $container31->containerBox->height->setValue(20);
        $container32 = new Container();
        $container32->containerBox->width->setValue(130);
        $container32->containerBox->height->setValue(20);
        $container3->addChildContainer($container31);
        $container3->addChildContainer($container32);


        $baseContainer->addChildContainer($container1);
        $baseContainer->addChildContainer($container2);
        $baseContainer->addChildContainer($container3);

        $baseContainer->calcAll();

        // Render
        $containerPdfRenderer = $baseContainer->getContainerRenderer();
        $containerPdfRenderer->render($this->canvas, $baseContainer);

        // Output Image
        $this->canvas->Output();
    }

    public function drawSplitLineTest()
    {
        $this->canvas->drawLine(20, 20, 100, 100);

        $this->canvas->drawLine(30, 20, 100, 20);

        // Output Image
        $this->canvas->Output();
    }
}
