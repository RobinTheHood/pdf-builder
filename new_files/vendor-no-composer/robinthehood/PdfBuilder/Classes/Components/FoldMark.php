<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class FoldMark extends Container implements ComponentInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->setContainerRenderer(new FoldMarkRenderer());
    }

    public function render(Pdf $pdf): void
    {
        $foldMark1PosY = 87; // Unit: mm
        $foldMark2PosY = 192; // Unit: mm
        $holeMarkPosY = 148.5; // Unit: mm

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Line(5, $foldMark1PosY, 8, $foldMark1PosY);
        $pdf->Line(5, $holeMarkPosY, 8, $holeMarkPosY);
        $pdf->Line(5, $foldMark2PosY, 8, $foldMark2PosY);
    }
}
