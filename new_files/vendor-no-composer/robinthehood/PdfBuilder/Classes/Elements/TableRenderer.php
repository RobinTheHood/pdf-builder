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
    public function render(ContainerRendererCanvasInterface $canvas, ContainerInterface $container): void
    {
        parent::render($canvas, $container);

        /**
         * @var Talbe $textArea
         */
        $table = $container;

        /**
         * @var Pdf $pdf
         */
        $pdf = $canvas;

        $this->renderTable($pdf, $table);
    }

    private function renderTable(Pdf $pdf, Table $table): void
    {
        $x = $table->getCalcedContainer()->containerBox->getContentBox()['x'];
        $this->renderY = $table->getCalcedContainer()->containerBox->getContentBox()['y'];
        //$y = $pdf->getYPositionOnPage($y);

        //var_dump($y);
        //$y %= (297 - 34);
        //var_dump($y);
        //$pdf->setXY($x, $y);

        $pdf->SetFont($this->fontFamily, Pdf::FONT_WEIGHT_BOLD, 10);
        foreach ($table->getRows() as $index => $row) {
            $this->renderRow($pdf, $table, $row, $table->getRowsOptions()[$index]);
        }
    }

    private function renderRow(Pdf $pdf, Table $table, array $row, array $rowOptions): void
    {
        $subRows = $table->splitRowInMultibleSubRows($pdf, $row, $rowOptions);

        if ($rowOptions['border'] == Table::ROW_BORDER_BOTTOM) {
            $rowOptions['border'] = '';
            $lastBorder = Table::ROW_BORDER_BOTTOM;
        }

        $fontSize = $rowOptions['fontSize'] ?? '10';

        $count = 0;
        //$y = $table->getCalcedContainer()->containerBox->getContentBox()['y'];
        $height = $this->rowOptions['height'] ?? $fontSize / Pdf::POINTS_PER_MM;
        foreach ($subRows as $subRow) {
            if (++$count == count($subRows)) {
                $rowOptions['border'] = $lastBorder;
            }
            $this->renderSubRow($pdf, $table, $subRow, $rowOptions, $this->renderY, $height);
            $this->renderY += $height;
        }
    }

    private function renderSubRow(Pdf $pdf, Table $table, array $subRow, array $rowOptions, float $y, float $height): void
    {
        $border = $rowOptions['border'] ?? 0;
        $fontWeight = $rowOptions['fontWeight'] ?? '';
        $fontSize = $rowOptions['fontSize'] ?? '10';

        //$height = $rowOptions['height'] ?? 5;
        //$height = $this->rowOptions['height'] ?? $fontSize / Pdf::POINTS_PER_MM;

        $x = $table->getCalcedContainer()->containerBox->getContentBox()['x'];
        //$pdf->setX($x);
        foreach ($subRow as $index => $cell) {
            $cell['width'] = $cell['width'] ?? $table->getColumnWidths()[$index];
            $cell['style'] = $cell['style'] ?? Pdf::FONT_WEIGHT_BOLD;
            $cell['alignment'] = $cell['alignment'] ?? 'L';

            $pdf->SetFont($table->fontFamily, $fontWeight, $fontSize);

            $pdf->drawText($cell['content'] ?? '', $x, $y, $cell['width'], $height);

            // $pdf->Cell(
            //     $cell['width'],
            //     $height,
            //     $cell['content'],
            //     $border,
            //     Pdf::CELL_NEW_LINE_OFF,
            //     $cell['alignment']
            // );

            if ($index == $table->columns - 1) {
                break;
            }

            $x += $cell['width'];
        }
    }
}
