<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Templates;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Section;
use RobinTheHood\PdfBuilder\Classes\Elements\Document;
use RobinTheHood\PdfBuilder\Classes\Elements\Image;
use RobinTheHood\PdfBuilder\Classes\Elements\PageDecorator;
use RobinTheHood\PdfBuilder\Classes\Elements\TextArea;
use RobinTheHood\PdfBuilder\Classes\Components\FoldMark;
use RobinTheHood\PdfBuilder\Classes\Components\Address;
use RobinTheHood\PdfBuilder\Classes\Components\Infoblock;
use RobinTheHood\PdfBuilder\Classes\Components\OrderTable;

class Bill
{
    private $document;

    public function __construct()
    {
        $section = new Section();

        // Logo
        $logo = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/rth_logo.png');
        $logo->setPositionX(145);
        $logo->setPositionY(9);
        $logo->setWidth(40);
        $section->addComponent($logo);

        // Address
        $address = new Address();
        $address->setAddress("Musterfirma GmbH\nz.H. Max Mustermann\nHauptstraße 999\n12345 Neustadt\nDeutschland");
        $address->setSender("Max Mustermann - 12345 Neustadt 1\n");
        $section->addComponent($address);

        // Infoblock
        $infoblock = new Infoblock();
        $section->addComponent($infoblock);

        // Heading
        $contentHeading = new TextArea();
        $contentHeading->setBounds(25, 103.46, 175, 10);
        $contentHeading->setFontSize(18);
        $contentHeading->setFontWeight(PDF::FONT_WEIGHT_BOLD);
        $contentHeading->setText('Rechnung');
        $section->addComponent($contentHeading);

        // Content Intro Text
        $contentIntroText = new TextArea();
        $contentIntroText->setBounds(25, 103.46 + 10, 175, 10);
        $contentIntroText->setFontSize(10);
        $contentIntroText->setLineHeight(5); // Unit: mm
        $contentIntroText->setFontWeight(PDF::FONT_WEIGHT_NORMAL);
        $contentIntroText->setText("Sehr geehrte Frau Lena Musterfrau,\nwir freuen uns, dass Sie bei online-shop.de bestellt haben.");
        $section->addComponent($contentIntroText);

        // OrderTable
        $orderTable = new OrderTable();
        for ($i = 0; $i < 50; $i++) {
            $orderTable->addItem([
                'quantity' => '19',
                'name' => "Ein grünes T-Shirt\n- mit roten Punkten\n- mit gelben Streifen",
                'model' => 'ts001r',
                'price' => '12.99',
                'vat' => '19%',
                'priceTotal' => ((string) (12.99 * 19)) . ' €'
            ]);
        }

        $section->addComponent($orderTable);

        $dinImage = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/din_5008_a.png');
        //$dinImage = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/rechnung_demo_1.png');
        $dinImage->setPositionX(0);
        $dinImage->setPositionY(0);
        $dinImage->setWidth(210);

        $pageDecorator = new PageDecorator();
        //$pageDecorator->addComponent($dinImage);
        $pageDecorator->addComponent(new FoldMark());

        $section->setPageDecorator($pageDecorator);
        $this->document = new Document();
        $this->document->addSection($section);
        $this->document->addSection($section);
    }

    public function render(): void
    {
        $this->document->render();
    }
}
