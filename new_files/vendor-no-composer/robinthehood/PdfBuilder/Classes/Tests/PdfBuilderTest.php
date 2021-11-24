<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Tests;

use RobinTheHood\PdfBuilder\Classes\Old\PdfBill;
use RobinTheHood\PdfBuilder\Classes\Templates\Letter;

class PdfBuilderTest
{
    public function test1(): void
    {
        $pdfBill = new PdfBill();
        $pdfBill->addBill(27);
        $pdf = $pdfBill->getPdf();

        $pdf->Output();
    }

    public function test2(): void
    {
        $letter = new Letter();
        $letter->render();
    }
}
