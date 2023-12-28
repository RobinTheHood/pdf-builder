<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

class PageLineSplitter
{
    public function cutLine(float $x1, float $y1, float $x2, float $y2, PageMapper $pageMapper): array
    {
        $mappedY1 = $pageMapper->mapY($y1);
        $mappedY2 = $pageMapper->mapY($y2);
        $relativeY1 = $mappedY1['y'];
        $relativeX1 = $x1;
        $pageStart = $mappedY1['relativPageNo'];
        $pageEnd = $mappedY2['relativPageNo'];
        $pages = $pageEnd - $pageStart + 1;

        // Horizontale Linie
        if ($y1 == $y2) {
            return [[
                'x1' => $x1,
                'y1' => $mappedY1['y'],
                'x2' => $x2,
                'y2' => $mappedY2['y'],
                'page' => $mappedY1['relativPageNo'],
            ]];
        }

        // Umgekehrte Steigung berechnen. Also m = dx/dy und nicht m = dy/dx
        $m = ($x2 - $x1) / ($y2 - $y1);

        for ($deltaPage = 0; $deltaPage < $pages; $deltaPage++) {
            $page = $pageStart + $deltaPage;
            if ($deltaPage < $pages - 1) {
                $cutLineY = $pageMapper->getPageContentHeight($page);
            } else {
                $cutLineY = $mappedY2['y'];
            }
            $relativeY2 = $cutLineY;

            $deltaX = $m * ($relativeY2 - $relativeY1);
            $relativeX2 = $relativeX1 + $deltaX;

            $lines[] = [
                'x1' => $relativeX1,
                'y1' => $relativeY1,
                'x2' => $relativeX2,
                'y2' => $relativeY2,
                'page' => $page,
            ];

            $relativeX1 = $relativeX2;
            $relativeY1 = 0;
        }

        return $lines;
    }
}
