<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class Header
{
    public function render($pdf)
    {
        $fontFamily = 'DejaVu';
        $cellWidth = 0;
        $cellHeight = 4;

        $pdf->SetFont($fontFamily, '', 9);

        // Headertext
        $pdf->Cell($cellWidth, $cellHeight, RTH_PDF_BUILDER_HEADER, Pdf::CELL_BORDER_NONE, Pdf::CELL_NEW_LINE);

        if (defined('RTH_PDF_BUILDER_SHOW_DOCUMENT_ID') && RTH_PDF_BUILDER_SHOW_DOCUMENT_ID == 'true') {
            $text = 'PLATZHALTER-DOCUMENT-ID';
            $pdf->Cell($cellWidth, $cellHeight, $text, Pdf::CELL_BORDER_NONE, Pdf::CELL_NEW_LINE, Pdf::CELL_ALIGN_LEFT);
        }

        // Seitenzahl
        if (defined('RTH_PDF_BUILDER_HIDE_PAGES') && RTH_PDF_BUILDER_HIDE_PAGES != 'true') {
            $text = RTH_PDF_BUILDER_PAGE . ' ' . $pdf->PageNo() . ' ' . RTH_PDF_BUILDER_PAGE_FROM . ' {nb}';
            $pdf->Cell(
                $cellWidth,
                $cellHeight,
                $text,
                Pdf::CELL_BORDER_NONE,
                Pdf::CELL_NEW_LINE_OFF,
                Pdf::CELL_ALIGN_RIGHT
            );
        }
    }
}
