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

    public $defaultFontFamily = 'DejaVu';
    public $defualtFontStyle = Pdf::FONT_STYLE_NORMAL;
    public $defualtFontSize = 10;

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

        $tableHeight = 0;
        foreach ($this->rows as $index => $row) {
            $rowOptions = $this->rowsOptions[$index];
            $fontSize = $rowOptions['fontSize'] ?? $this->defualtFontSize;
            $fontLineHeight = $fontSize / Pdf::POINTS_PER_MM;
            $rowHeight = $this->rowOptions['height'] ?? $fontLineHeight;

            $subRows = $this->splitRowInMultibleSubRows($row, $rowOptions);
            $tableHeight += $rowHeight * count($subRows);
        }
        $this->getCalcedContainer()->containerBox->height->setValue($tableHeight);
    }

    public function splitRowInMultibleSubRows($row, $rowOptions)
    {
        $maxLines = 0;
        foreach ($row as $index => $cell) {
            $content = $cell['content'];
            $width = $cell['width'] ?? $this->columnWidths[$index] ?? 0;
            $fontStyle = $rowOptions['fontWeight'] ?? $this->defualtFontStyle;
            $fontSize = $rowOptions['fontSize'] ?? $this->defualtFontSize;
            $fontFamily = $rowOptions['fontFamily'] ?? $this->defaultFontFamily;

            $stringSplitter = StringSplitter::getStringSplitter();
            $lines[$index] = $stringSplitter->splitByLength($content, $width, $fontFamily, $fontStyle, $fontSize);

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
