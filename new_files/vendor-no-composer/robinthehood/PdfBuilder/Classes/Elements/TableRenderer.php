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
    /**
     * @var int $renderY
     */
    private $renderY = 0;

    public function render(ContainerRendererCanvasInterface $canvas, ContainerInterface $container): void
    {
        parent::render($canvas, $container);

        /**
         * @var Table $textArea
         */
        $table = $container;

        $this->renderTable($canvas, $table);
    }

    private function renderTable(ContainerRendererCanvasInterface $canvas, Table $table): void
    {
        $this->renderY = $table->getCalcedContainer()->containerBox->getContentBox()['y'];
        foreach ($table->getRows() as $index => $row) {
            $this->renderRow($canvas, $table, $row, $table->getRowsOptions()[$index]);
        }
    }

    private function renderRow(
        ContainerRendererCanvasInterface $canvas,
        Table $table,
        array $row,
        array $rowOptions
    ): void {
        $subRows = $table->splitRowInMultibleSubRows($row, $rowOptions);

        if ($rowOptions['border'] == Table::ROW_BORDER_BOTTOM) {
            $rowOptions['border'] = '';
            $lastBorder = Table::ROW_BORDER_BOTTOM;
        }

        $fontSize = $rowOptions['fontSize'] ?? $table->defualtFontSize;
        $fontLineHeight = $fontSize / Pdf::POINTS_PER_MM;
        $rowHeight = $rowOptions['height'] ?? $fontLineHeight;
        $paddingBottom = $rowOptions['paddingBottom'] ?? 0;

        $count = 0;
        foreach ($subRows as $subRow) {
            if (++$count == count($subRows)) {
                $rowOptions['border'] = $lastBorder;
            }
            $this->renderSubRow($canvas, $table, $subRow, $rowOptions, $this->renderY, $rowHeight);
            $this->renderY += $rowHeight;
        }
        $this->renderY += $paddingBottom;
    }

    private function renderSubRow(
        ContainerRendererCanvasInterface $canvas,
        Table $table,
        array $subRow,
        array $rowOptions,
        float $y,
        float $rowHeight
    ): void {
        //$border = $rowOptions['border'] ?? 0;
        $fontFamily = $rowOptions['fontFamily'] ?? $table->defaultFontFamily;
        $fontStyle = $rowOptions['fontWeight'] ?? $table->defualtFontStyle;
        $fontSize = $rowOptions['fontSize'] ?? $table->defualtFontSize;

        $x = $table->getCalcedContainer()->containerBox->getContentBox()['x'];
        foreach ($subRow as $index => $cell) {
            $content = $cell['content'] ?? '';
            $width = $cell['width'] ?? $table->getColumnWidths()[$index];
            $textAlignment = $cell['alignment'] ?? $table->defaultAlignment;

            $canvas->setFontToDo($fontFamily, $fontStyle, $fontSize);
            $canvas->drawText($content, $x, $y, $width, $rowHeight, $textAlignment);

            $x += $width;
        }
    }
}
