<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Pdf\StringSplitter;

class Table extends Container
{
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

        $height = 0;
        foreach ($this->rows as $index => $row) {
            $rowOptions = $this->rowsOptions[$index];
            $fontSize = $rowOptions['fontSize'] ?? 10;
            $subRows = $this->splitRowInMultibleSubRows($row, $rowOptions);
            foreach ($subRows as $subRow) {
                $lineHeight = $this->rowOptions['height'] ?? $fontSize / Pdf::POINTS_PER_MM;
                $height += $lineHeight;
            }
        }
        $this->getCalcedContainer()->containerBox->height->setValue($height);
    }

    public function splitRowInMultibleSubRows($row, $rowOptions)
    {
        $maxLines = 0;
        foreach ($row as $index => $cell) {
            $cell['width'] = $cell['width'] ?? $this->columnWidths[$index] ?? 0;
            $fontWeight = $rowOptions['fontWeight'] ?? ''; // 'B'
            $fontSize = $rowOptions['fontSize'] ?? 10; // 'B'

            $stringSplitter = StringSplitter::getStringSplitter();
            $lines[$index] = $stringSplitter->splitByLength($cell['content'], $cell['width'], $this->fontFamily, $fontWeight, $fontSize);

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
