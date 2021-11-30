<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Templates;

use RobinTheHood\PdfBuilder\Classes\Elements\Cell;
use RobinTheHood\PdfBuilder\Classes\Elements\Section;
use RobinTheHood\PdfBuilder\Classes\Elements\Document;

class ComponentTest
{
    private $document;

    public function __construct()
    {
        $section = new Section();

        $cell = new Cell();
        $cell->setBounds(25, 25, 100, 100);

        $cell2 = new Cell();
        $cell2->setBounds(25, 25, 50, 50);

        $cell3 = new Cell();
        $cell3->setBounds(25 / 2, 25 / 2, 25, 25);
        $cell2->addChildComponent($cell3);
        $cell->addChildComponent($cell2);
        $section->addChildComponent($cell);

        $this->document = new Document();
        $this->document->addSection($section);
    }

    public function render(): void
    {
        $this->document->calcComponents();
        $this->document->render();
    }
}
