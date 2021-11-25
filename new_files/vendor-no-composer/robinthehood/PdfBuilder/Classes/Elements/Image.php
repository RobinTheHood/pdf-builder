<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class Image implements ComponentInterface
{
    private const SIZE_X = 0;

    private $imagePath = DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/rth_logo.png';
    private $posX = 0;
    private $posY = 0;
    private $scale = 1;

    public function render(Pdf $pdf): void
    {
        $size = getimagesize($this->imagePath);
        $scale = ($size[self::SIZE_X] / 300 * 25.4) * $this->scale;
        $pdf->Image($this->imagePath, $this->posX, $this->posY, $scale);
    }
}