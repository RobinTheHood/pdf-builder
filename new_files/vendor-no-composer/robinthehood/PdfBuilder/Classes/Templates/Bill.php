<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Templates;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Section;
use RobinTheHood\PdfBuilder\Classes\Elements\Document;
use RobinTheHood\PdfBuilder\Classes\Elements\Image;
use RobinTheHood\PdfBuilder\Classes\Elements\PageDecorator;
use RobinTheHood\PdfBuilder\Classes\Elements\TextArea;
use RobinTheHood\PdfBuilder\Classes\Elements\Table;
use RobinTheHood\PdfBuilder\Classes\Elements\FooterDecorator;
use RobinTheHood\PdfBuilder\Classes\Components\FoldMark;
use RobinTheHood\PdfBuilder\Classes\Components\Address;
use RobinTheHood\PdfBuilder\Classes\Components\ContentArea;
use RobinTheHood\PdfBuilder\Classes\Components\Infoblock;
use RobinTheHood\PdfBuilder\Classes\Components\OrderTable;
use RobinTheHood\PdfBuilder\Classes\Components\OrderTotalTable;
use RobinTheHood\PdfBuilder\Classes\Container\Container;

class Bill
{
    private $document;

    public function __construct()
    {
        $this->createBill2();
    }

    private function createBill1(): void
    {
        $section = new Section();

        // Logo
        $logo = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/rth_logo.png');
        $logo->setPositionX(145);
        $logo->setPositionY(9);
        $logo->setWidth(40);
        $section->addChildComponent($logo);

        // Address
        $address = new Address();
        $address->setAddress("Musterfirma GmbH\nz.H. Max Mustermann\nHauptstraße 999\n12345 Neustadt\nDeutschland");
        $address->setSender("Max Mustermann - 12345 Neustadt 1\n");
        $section->addChildComponent($address);

        // Infoblock
        $infoblock = new Infoblock();
        $section->addChildComponent($infoblock);

        // Heading
        $contentHeading = new TextArea();
        $contentHeading->setBounds(25, 103.46, 175, 10);
        $contentHeading->setFontSize(18);
        $contentHeading->setFontWeight(PDF::FONT_WEIGHT_BOLD);
        $contentHeading->setText('Rechnung');
        $section->addChildComponent($contentHeading);

        // Content Intro Text
        $contentIntroText = new TextArea();
        $contentIntroText->setBounds(25, 103.46 + 10, 175, 10);
        $contentIntroText->setFontSize(10);
        $contentIntroText->setLineHeight(5); // Unit: mm
        $contentIntroText->setFontWeight(PDF::FONT_WEIGHT_NORMAL);
        $contentIntroText->setText("Sehr geehrte Frau Lena Musterfrau,\nwir freuen uns, dass Sie bei online-shop.de bestellt haben.\nDiese Zeile ist zuviel.");
        $section->addChildComponent($contentIntroText);

        // OrderTable
        $orderTable = new OrderTable();
        for ($i = 0; $i < 10; $i++) {
            $orderTable->addItem([
                'quantity' => '19',
                'name' => "Ein grünes T-Shirt\n- mit roten Punkten\n- mit gelben Streifen",
                'model' => 'ts001r',
                'price' => '12.99',
                'vat' => '19%',
                'priceTotal' => ((string) (12.99 * 19)) . ' €'
            ]);
        }
        $section->addChildComponent($orderTable);

        // OrderTotalTable
        $orderTotalTable = new OrderTotalTable();
        $section->addChildComponent($orderTotalTable);

        // Content Outro Text
        $contentOutoText = new TextArea();
        //$contentOutoText->setBounds(25, 103.46 + 10, 175, 10);
        $contentOutoText->setPositionX(25);
        $contentOutoText->setDimention(175, 10);
        $contentOutoText->setFontSize(10);
        $contentOutoText->setLineHeight(5); // Unit: mm
        $contentOutoText->setFontWeight(PDF::FONT_WEIGHT_NORMAL);
        $contentOutoText->setText("Vielen Dank für Ihren Auftrag. Besuchen Sie uns wieder unter online-shop.de. Leistungsdatum entspricht Rechnungsdatum. Es gelten unsere Allgemeinen Geschäftsbedingungen.");
        $section->addChildComponent($contentOutoText);

        $dinImage = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/din_5008_a.png');
        //$dinImage = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/rechnung_demo_1.png');
        $dinImage->setPositionX(0);
        $dinImage->setPositionY(0);
        $dinImage->setWidth(210);

        $pageDecorator = new PageDecorator();
        //$pageDecorator->addChildContainer($dinImage);
        $pageDecorator->addChildContainer(new FoldMark());

        $tableFooter = new Table();

        $width = 60;
        $tableFooter->setColumnWidths([
            $width,
            $width,
            $width,
        ]);

        $tableFooter->addRow([
            ['content' => "MAX MUSTERFIRMA\nMustermann Straße 1\n12345 Musterstadt", 'alignment' => Pdf::CELL_ALIGN_LEFT],
            ['content' => "www.musterfirma.de\ninfo@musterfirma.de\n+49 1234 1111-0", 'alignment' => Pdf::CELL_ALIGN_LEFT],
            ['content' => "BLZ: 123456789\nIBAN: DE123456789123456789\nUSt-ID: DE123456789", 'alignment' => Pdf::CELL_ALIGN_LEFT],
        ], ['fontWeight' => Pdf::FONT_WEIGHT_NORMAL, 'border' => Table::ROW_BORDER_NONE]);

        $footer = new FooterDecorator();
        $footer->addChildComponent($tableFooter);

        $section->setPageDecorator($pageDecorator);
        $section->setFooterDecorator($footer);

        $this->document = new Document();
        $this->document->addSection($section);
        $this->document->addSection($section);
    }

    private function createBill2(): void
    {
        $section = new Section();

        // Logo
        $logo = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/rth_logo.png');
        $logo->setPositionX(145);
        $logo->setPositionY(9);
        $logo->setWidth(40);
        //$section->addChildComponent($logo);

        // use new container
        $logo->position = Container::POSITION_ABSOLUT;
        $logo->containerBox->positionX->setValue(145);
        $logo->containerBox->positionY->setValue(9);
        $logo->containerBox->width->setValue(40);
        $logo->containerBox->height->setValue(13); // only needed for tests
        $section->addChildContainer($logo);

        // Address
        $address = new Address();
        $address->setAddress("Musterfirma GmbH\nz.H. Max Mustermann\nHauptstraße 999\n12345 Neustadt\nDeutschland");
        $address->setSender("Max Mustermann - 12345 Neustadt 1\n");
        //$section->addChildComponent($address);
        $section->addChildContainer($address);

        // Infoblock
        $infoblock = new Infoblock();
        //$section->addChildComponent($infoblock);
        $section->addChildContainer($infoblock);

        // Content Area
        $contentArea = new ContentArea();

        // Heading
        $contentHeading = new TextArea();
        //$contentHeading->setBounds(25, 103.46, 175, 10);
        //$contentHeading->setDimention(175, 10);
        $contentHeading->setFontSize(18);
        $contentHeading->setFontWeight(Pdf::FONT_WEIGHT_BOLD);
        $contentHeading->setText('Rechnung');
        $contentHeading->containerBox->marginBottom->setValue(2);
        $contentArea->addChildComponent($contentHeading);

        // use new container
        //$contentHeading->containerBox->height->setValue(30 / (72 / 25.4)); // only needed for tests
        $contentArea->addChildContainer($contentHeading);

        // Content Intro Text
        $contentIntroText = new TextArea();
        //$contentIntroText->setBounds(25, 103.46 + 10, 175, 10);
        $contentIntroText->setDimention(175, 10);
        $contentIntroText->setFontSize(10);
        $contentIntroText->setLineHeight(5); // Unit: mm
        $contentIntroText->setFontWeight(Pdf::FONT_WEIGHT_NORMAL);
        $contentIntroText->setText("Sehr geehrte Frau Lena Musterfrau,\nwir freuen uns, dass Sie bei online-shop.de bestellt haben.");
        $contentArea->addChildComponent($contentIntroText);

        // use new container
        //$contentIntroText->containerBox->height->setValue(15); // only needed for tests
        $contentArea->addChildContainer($contentIntroText);

        // OrderTable
        $orderTable = new OrderTable();
        for ($i = 0; $i < 20; $i++) {
            $orderTable->addItem([
                'quantity' => '19',
                'name' => "Ein grünes T-Shirt\n- mit roten Punkten\n- mit gelben Streifen",
                'model' => 'ts001r',
                'price' => '12.99',
                'vat' => '19%',
                'priceTotal' => ((string) (12.99 * 19)) . ' €'
            ]);
        }
        //$section->addChildComponent($orderTable);
        $contentArea->addChildContainer($orderTable);

        $section->addChildContainer($contentArea);

        $dinImage = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/din_5008_a.png');
        //$dinImage = new Image(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/rechnung_demo_1.png');
        $dinImage->setPositionX(0);
        $dinImage->setPositionY(0);
        $dinImage->setWidth(210);

        $pageDecorator = new PageDecorator();
        //$pageDecorator->addChildContainer($dinImage);
        $pageDecorator->addChildContainer(new FoldMark());

        $tableFooter = new Table();

        $width = 60;
        $tableFooter->setColumnWidths([
            $width,
            $width,
            $width,
        ]);

        $tableFooter->addRow([
            ['content' => "MAX MUSTERFIRMA\nMustermann Straße 1\n12345 Musterstadt", 'alignment' => Pdf::CELL_ALIGN_LEFT],
            ['content' => "www.musterfirma.de\ninfo@musterfirma.de\n+49 1234 1111-0", 'alignment' => Pdf::CELL_ALIGN_LEFT],
            ['content' => "BLZ: 123456789\nIBAN: DE123456789123456789\nUSt-ID: DE123456789", 'alignment' => Pdf::CELL_ALIGN_LEFT],
        ], ['fontWeight' => Pdf::FONT_WEIGHT_NORMAL, 'border' => Table::ROW_BORDER_NONE]);

        $footer = new FooterDecorator();
        //$footer->addChildComponent($tableFooter);
        $footer->addChildContainer($tableFooter);

        $section->setPageDecorator($pageDecorator);
        $section->setFooterDecorator($footer);

        $this->document = new Document();
        $this->document->addSection($section);
        $this->document->addSection($section);
    }

    public function render(): void
    {
        $this->document->render();
    }
}
