<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

class PageLineSplitter
{
    private $lastOffset = 0;
    private $lastPageNo = 1;
    private $missedLines = [];

    private $pdf = null;


    // TODO: Calculate X1 and X2, for now only vertical and horizontal are possible
    public function cutLineNew(float $x1, float $y1, float $x2, float $y2, PageMapper $pageMapper): array
    {
        $mappedY1 = $pageMapper->mapY($y1);
        $mappedY2 = $pageMapper->mapY($y2);
        $pageStart = $mappedY1['relativPageNo'];
        $pageEnd = $mappedY2['relativPageNo'];
        $pages = $pageEnd - $pageStart + 1;

        $yy1 = $mappedY1['y'];
        if ($y1 == $y2) {
            return [[
                'x1' => $x1,
                'y1' => $mappedY1['y'],
                'x2' => $x2,
                'y2' => $mappedY2['y'],
                'page' => $mappedY1['relativPageNo'],
            ]];
        }

        for ($deltaPage = 0; $deltaPage < $pages; $deltaPage++) {
            $page = $pageStart + $deltaPage;
            if ($deltaPage < $pages - 1) {
                $cutLineY = $pageMapper->getPageContentHeight($page);
            } else {
                $cutLineY = $mappedY2['y'];
            }
            $yy2 = $cutLineY;

            $lines[] = [
                'x1' => $x1,
                'y1' => $yy1,
                'x2' => $x1,
                'y2' => $yy2,
                'page' => $page,
            ];

            $yy1 = 0;
        }

        return $lines;
    }

    public function cutLine(float $x1, float $y1, float $x2, float $y2, float $pageSize): array
    {
        $lines = [];

        $pageStart = (int) ($y1 / $pageSize);
        $pageEnd = (int) ($y2 / $pageSize);
        $pages = $pageEnd - $pageStart + 1;

        $deltaX = $x2 - $x1;
        $deltaY = $y2 - $y1;

        $cutLinePrevY = $y1;
        $yy2 = $y1;
        $xx2 = $x1;

        if ($y1 == $y2) {
            return [[
                'x1' => $x1,
                'y1' => $y1,
                'x2' => $x2,
                'y2' => $y2,
                'page' => $pageStart + 1,
            ]];
        }

        for ($deltaPage = 1; $deltaPage <= $pages; $deltaPage++) {
            $page = $pageStart + $deltaPage;
            if ($deltaPage < $pages) {
                $cutLineY = $pageSize * $page;
            } else {
                $cutLineY = $y2;
            }
            $dY = $cutLineY - $cutLinePrevY;
            $cutLinePrevY = $cutLineY;

            $yy1 = $yy2;
            $yy2 = $yy2 + $dY;

            $dX = $dY * ($deltaX / $deltaY);
            $xx1 = $xx2;
            $xx2 = $xx2 + $dX;

            $lines[] = [
                'x1' => $xx1,
                'y1' => $yy1,
                'x2' => $xx2,
                'y2' => $yy2,
                'page' => $page,
            ];
        }

        return $lines;
    }

    public function drawLineNew(float $x1, float $y1, float $x2, float $y2): void
    {
        $drawSize = Pdf::PAGE_DIN_A4_HEIGHT - 35;
        $pageSize = $drawSize;
        $lines = $this->cutLine($x1, $y1, $x2, $y2, $pageSize);
        $lines = array_merge($this->missedLines, $lines);
        $this->missedLines = [];
        foreach ($lines as $line) {
            if ($line['page'] != $this->pdf->PageNo()) {
                $this->missedLines[] = $line;
                continue;
            }
            // $newY1 = $line['y1'] % ($drawSize+1);
            // $newY2 = $line['y2'] % ($drawSize+1);

            $newY1 = $this->getYPositionOnPage($line['y1']);
            $newY2 = $this->getYPositionOnPage($line['y2']);

            $this->pdf->SetDrawColor(0, 255 * ($line['page'] % 2), 255 * (($line['page'] + 1) % 2));
            $this->pdf->Line($line['x1'], $newY1, $line['x2'], $newY2);
        }
        return;

        $y1 = $this->getYPositionOnPage($y1);
        $y2 = $this->getYPositionOnPage($y2);
        $this->pdf->Line($x1, $y1, $x2, $y2);
    }

    private function getYPositionOnPage(float $y): float
    {
        if ($this->lastPageNo < $this->pdf->PageNo()) {
            $this->lastOffset = $y - $this->pdf->GetY();
            $this->lastPageNo = $this->pdf->PageNo();
        }
        return $y - $this->lastOffset;
    }

    public function resetOffsetNew()
    {
        $this->lastOffset = 0;
        $this->lastPageNo = $this->pdf->PageNo();
        $this->yOffset = 0;
        $this->lastResetPageNo = $this->pdf->PageNo() - 1;
    }
}
