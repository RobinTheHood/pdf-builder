<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

class PageMapper
{
    use PageMarginTrait;

    /**
     * @var Pdf $pdf;
     */
    private $pdf = null;

    private $lastResetPageNo = 0;

    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function reset()
    {
        $this->lastResetPageNo = $this->pdf->PageNo() - 1;
    }

    public function mapYOnPage(float $globalY, float $height = 0): array
    {
        $y = $this->mapY($globalY, $height);
        $y['yOnPage'] = $this->yOnPage($y['y'], $y['relativPageNo']);
        return $y;
    }

    public function yOnPage(float $y, int $relativPageNo): float
    {
        $pageMargin = $this->getPageMargin($relativPageNo - 1);
        return $y + $pageMargin['top'];
    }

    public function doPageBreak(array $y): void
    {
        $relativPageNo = $this->getRelativPageNo();
        if ($relativPageNo < $y['relativPageNo']) {
            $this->drawPageMargins();
            $this->pdf->addPage();
            $this->pdf->SetXY(0, 0);
        }
    }

    public function getRelativPageNo(): int
    {
        return $this->pdf->PageNo() - $this->lastResetPageNo;
    }

    public function getPageContentHeight(int $relativPageNo): float
    {
        $pageMargin = $this->getPageMargin($relativPageNo - 1);
        return Pdf::PAGE_DIN_A4_HEIGHT - $pageMargin['top'] - $pageMargin['bottom'];
    }

    public function mapY(float $globalY, float $height = 0): array
    {
        $globalYCutBefor = 0;
        $globalYCut = 0;
        $relativPageNo = 0;

        while (1) {
            $relativPageNo++;
            $globalYCutBefor = $globalYCut;
            $globalYCut += $this->getPageContentHeight($relativPageNo);
            if ($globalY + $height > $globalYCut) {
                continue;
            }
            $relativY = $globalY - $globalYCutBefor;
            break;
        }

        return [
            'y' => $relativY,
            'relativPageNo' => $relativPageNo
        ];
    }

    private function drawPageMargins()
    {
        $relativPageNo = $this->getRelativPageNo();
        $pageMargin = $this->getPageMargin($relativPageNo);

        $topY = $pageMargin['top'];
        $bottomY = Pdf::PAGE_DIN_A4_HEIGHT - $pageMargin['bottom'];

        $this->pdf->SetDrawColor(255, 0, 0);
        $this->pdf->Line(0, $topY, 210, $topY);
        $this->pdf->Line(0, $bottomY, 210, $bottomY);
    }
}
