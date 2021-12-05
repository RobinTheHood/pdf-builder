<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\ContainerRenderer;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererInterface;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerRendererCanvasInterface;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class TableRenderer extends ContainerRenderer implements ContainerRendererInterface
{
    private $renderY = 0;

    public function render(ContainerRendererCanvasInterface $canvas, ContainerInterface $container): void
    {
        parent::render($canvas, $container);

        /**
         * @var Talbe $textArea
         */
        $table = $container;

        $this->renderTable($canvas, $table);
    }

    private function renderTable(ContainerRendererCanvasInterface $canvas, Table $table): void
    {
        $this->renderY = $table->getCalcedContainer()->containerBox->getContentBox()['y'];
        $canvas->setFontToDo($table->fontFamily, Pdf::FONT_WEIGHT_BOLD, 10);
        foreach ($table->getRows() as $index => $row) {
            $this->renderRow($canvas, $table, $row, $table->getRowsOptions()[$index]);
        }
    }

    private function renderRow(ContainerRendererCanvasInterface $canvas, Table $table, array $row, array $rowOptions): void
    {
        $subRows = $table->splitRowInMultibleSubRows($row, $rowOptions);

        if ($rowOptions['border'] == Table::ROW_BORDER_BOTTOM) {
            $rowOptions['border'] = '';
            $lastBorder = Table::ROW_BORDER_BOTTOM;
        }

        $fontSize = $rowOptions['fontSize'] ?? 10;

        $count = 0;
        $height = $this->rowOptions['height'] ?? $fontSize / Pdf::POINTS_PER_MM;
        foreach ($subRows as $subRow) {
            if (++$count == count($subRows)) {
                $rowOptions['border'] = $lastBorder;
            }
            $this->renderSubRow($canvas, $table, $subRow, $rowOptions, $this->renderY, $height);
            $this->renderY += $height;
        }
    }

    private function renderSubRow(ContainerRendererCanvasInterface $canvas, Table $table, array $subRow, array $rowOptions, float $y, float $height): void
    {
        $border = $rowOptions['border'] ?? 0;
        $fontWeight = $rowOptions['fontWeight'] ?? '';
        $fontSize = $rowOptions['fontSize'] ?? 10;

        $x = $table->getCalcedContainer()->containerBox->getContentBox()['x'];
        foreach ($subRow as $index => $cell) {
            $cell['width'] = $cell['width'] ?? $table->getColumnWidths()[$index];
            $cell['style'] = $cell['style'] ?? Pdf::FONT_WEIGHT_BOLD;
            $cell['alignment'] = $cell['alignment'] ?? 'L';

            $canvas->setFontToDo($table->fontFamily, $fontWeight, $fontSize);
            $canvas->drawText($cell['content'] ?? '', $x, $y, $cell['width'], $height);

            if ($index == $table->columns - 1) {
                break;
            }

            $x += $cell['width'];
        }
    }
}
