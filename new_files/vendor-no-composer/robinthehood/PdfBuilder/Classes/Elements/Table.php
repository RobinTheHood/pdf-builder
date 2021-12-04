<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Pdf\StringSplitter;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\ComponentTrait;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class Table extends Container implements ComponentInterface
{
    use ComponentTrait;

    public const ROW_BORDER_BOTTOM = 'B';
    public const ROW_BORDER_NONE = '';

    public $fontFamily = 'DejaVu';

    private $columnWidths = [];
    private $rows = [];
    private $rowsOptions = [];

    public function __construct()
    {
        parent::__construct();
        $this->setContainerRenderer(new TableRenderer());
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function getRowsOptions(): array
    {
        return $this->rowsOptions;
    }

    public function getColumnWidths(): array
    {
        return $this->columnWidths;
    }

    public function setColumnWidths($columnWidths)
    {
        $this->columnWidths = $columnWidths;
    }

    public function addRow($row, $options = [])
    {
        $this->rows[] = $row;
        $this->rowsOptions[] = $options;
    }

    protected function calcSetHeight(): void
    {
        if ($this->containerBox->height->isSet()) {
            return;
        }

        $pdf = new Pdf();
        $pdf->AddFont($this->fontFamily, '', 'DejaVuSansCondensed.ttf', true);
        $pdf->AddFont($this->fontFamily, 'B', 'DejaVuSansCondensed-Bold.ttf', true);
        $pdf->SetFont($this->fontFamily);

        $height = 0;
        foreach ($this->rows as $index => $row) {
            $rowOptions = $this->rowsOptions[$index];
            $fontSize = $rowOptions['fontSize'] ?? 10;
            $subRows = $this->splitRowInMultibleSubRows($pdf, $row, $rowOptions);
            foreach ($subRows as $subRow) {
                $lineHeight = $this->rowOptions['height'] ?? $fontSize / Pdf::POINTS_PER_MM;
                $height += $lineHeight;
            }
        }
        $this->getCalcedContainer()->containerBox->height->setValue($height);
    }

    public function render(Pdf $pdf): void
    {
        $this->calcRenderPosition($pdf);
        $this->renderRows($pdf, $this->rows, $this->rowsOptions);
    }

    private function renderRows(Pdf $pdf, array $rows, array $rowsOptions): void
    {
        $pdf->SetFont($this->fontFamily, Pdf::FONT_WEIGHT_BOLD, 10);
        foreach ($rows as $index => $row) {
            $this->renderRow($pdf, $row, $rowsOptions[$index]);
        }
    }

    private function renderRow(Pdf $pdf, array $row, array $rowOptions): void
    {
        $subRows = $this->splitRowInMultibleSubRows($pdf, $row, $rowOptions);

        if ($rowOptions['border'] == self::ROW_BORDER_BOTTOM) {
            $rowOptions['border'] = '';
            $lastBorder = self::ROW_BORDER_BOTTOM;
        }

        $count = 0;
        foreach ($subRows as $subRow) {
            if (++$count == count($subRows)) {
                $rowOptions['border'] = $lastBorder;
            }
            $this->renderSubRow($pdf, $subRow, $rowOptions);
        }
    }

    private function renderSubRow(Pdf $pdf, array $subRow, array $rowOptions): void
    {
        $height = $rowOptions['height'] ?? 5;
        $border = $rowOptions['border'] ?? 0;
        $fontWeight = $rowOptions['fontWeight'] ?? '';
        $fontSize = $rowOptions['fontSize'] ?? '10';

        $x = $pdf->GetX();
        foreach ($subRow as $index => $cell) {
            $cell['width'] = $cell['width'] ?? $this->columnWidths[$index];
            $cell['style'] = $cell['style'] ?? Pdf::FONT_WEIGHT_BOLD;
            $cell['alignment'] = $cell['alignment'] ?? 'L';

            $pdf->SetFont($this->fontFamily, $fontWeight, $fontSize);

            $pdf->Cell(
                $cell['width'],
                $height,
                $cell['content'],
                $border,
                Pdf::CELL_NEW_LINE_OFF,
                $cell['alignment']
            );

            if ($index == $this->columns - 1) {
                break;
            }
        }
        $pdf->Ln();
        $pdf->SetX($x);
    }

    public function splitRowInMultibleSubRows(Pdf $pdf, $row, $rowOptions)
    {
        $maxLines = 0;
        foreach ($row as $index => $cell) {
            $cell['width'] = $cell['width'] ?? $this->columnWidths[$index] ?? 0;

            $fontWeight = $rowOptions['fontWeight'] ?? ''; // 'B'
            $fontSize = $rowOptions['fontSize'] ?? '10'; // 'B'

            $pdf->SetFont($this->fontFamily, $fontWeight, $fontSize);

            $lines[$index] = StringSplitter::splitByLength($pdf, $cell['content'], $cell['width']);

            if (count($lines[$index]) > $maxLines) {
                $maxLines = count($lines[$index]);
            }

            if ($index == $this->columns - 1) {
                break;
            }
        }

        $subRows = [];
        for ($i = 0; $i < $maxLines; $i++) {
            $subRow = [];
            foreach ($row as $index => $cell) {
                $newCell = [
                    'width' => $cell['width'],
                    'style' => $cell['style'],
                    'alignment' => $cell['alignment'],
                    'content' => $lines[$index][$i]
                ];
                $subRow[] = $newCell;
                if ($index == $this->columns - 1) {
                    break;
                }
            }
            $subRows[] = $subRow;
        }

        return $subRows;
    }
}
