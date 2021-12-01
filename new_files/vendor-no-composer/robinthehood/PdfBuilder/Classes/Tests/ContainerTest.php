<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Tests;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
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
        // $baseContainer->setPosition(10, 10);
        $baseContainer->containerBox->positionX->setValue(10);
        $baseContainer->containerBox->positionY->setValue(10);
        // $baseContainer->setPadding(20, 20);
        // $baseContainer->setBorder(10, 10);
        // $baseContainer->setDimentions(self::DEFAULT_WIDTH - 20, self:: DEFAULT_HEIGHT - 20);
        $baseContainer->containerBox->width->setValue(self::DEFAULT_WIDTH - 20);
        $baseContainer->containerBox->height->setValue(self:: DEFAULT_HEIGHT - 20);

        $container1 = new Container();
        //$container1->setPosition(20, 20);
        //$container1->setDimentions(180, 20);
        $container1->containerBox->width->setValue(180);
        $container1->containerBox->height->setValue(20);

        //$container1->setMargin(10, 10);
        //$container1->setBorder(2, 2, 2, 2);
        //$container1->setPadding(10, 20, 30, 40);

        $container2 = $container1->copy();
        // $container2->setDimentions(100, 20);
        $container2->containerBox->width->setValue(100);
        $container2->containerBox->height->setValue(20);

        $container3 = $container1->copy();
        // $container3->setDimentions(0, 20);
        $container3->containerBox->height->setValue(20);

        $container4 = $container1->copy();
        // $container4->setDimentions(70, 20);
        $container4->containerBox->width->setValue(70);
        $container4->containerBox->height->setValue(20);

        $container5 = $container1->copy();
        // $container5->setDimentions(60, 20);
        $container5->containerBox->width->setValue(60);
        $container5->containerBox->height->setValue(20);
        // $container4->setMargin(0, 0, 0, 10);
        $container5->containerBox->marginLeft->setValue(10);

        $container1->addChildContainer($container4);
        $container1->addChildContainer($container5);

        $container6 = $container1->copy();
        // $container6->setDimentions(10, 20);
        $container6->containerBox->width->setValue(10);
        $container6->containerBox->height->setValue(20);

        // $container7 = $container1->copy();
        // $container7->setDimentions(20, 20);

        $baseContainer->addChildContainer($container1);
        $baseContainer->addChildContainer($container2);
        $baseContainer->addChildContainer($container6);
        // $baseContainer->addChildContainer($container3);
        // $baseContainer->addChildContainer($container4);
        // $baseContainer->addChildContainer($container5);

        $baseContainer->calcAll();

        // Render
        $containerRenderer = $baseContainer->getContainerRenderer();
        $containerRenderer->render($this->canvas, $baseContainer);

        // Output Image
        $this->canvas->Output();
    }
}
