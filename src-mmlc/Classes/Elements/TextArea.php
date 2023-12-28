<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\TextTrait;

class TextArea extends Container
{
    use TextTrait;

    public const VERTICAL_ALIGN_TOP = 0;
    public const VERTICAL_ALIGN_BOTTOM = 2;
    public const OVERFLOW_Y_VISIBLE = 1;
    public const OVERFLOW_Y_HIDDEN = 0;

    /**
     * @var int $verticalAlign
     */
    private $verticalAlign = self::VERTICAL_ALIGN_TOP;

    /**
     * @var int $overflowY
     */
    private $overflowY = self::OVERFLOW_Y_VISIBLE;

    public function __construct()
    {
        parent::__construct();
        $this->setContainerRenderer(new TextAreaRenderer());
    }

    public function getVerticalAlign(): int
    {
        return $this->verticalAlign;
    }

    public function setVerticalAlign(int $verticalAlign): void
    {
        $this->verticalAlign = $verticalAlign;
    }

    public function setOverflowY(int $value): void
    {
        $this->overflowY = $value;
    }

    protected function calcSetHeight(): void
    {
        if ($this->containerBox->height->isSet()) {
            return;
        }

        $lineHeight = $this->getLineHeight();
        if ($lineHeight === null) {
            $lineHeight = $this->getFontHeight();
        }

        $contentWidth = $this->getCalcedContainer()->containerBox->getContentBox()['width'];
        $lines = $this->splitTextInLines($contentWidth);
        $height = $lineHeight * count($lines);
        $this->getCalcedContainer()->containerBox->height->setValue($height);
    }
}
