<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

trait PageMarginTrait
{
    /**
     * @var array $defaultPageMargin
     */
    private $defaultPageMargin = ['top' => 0, 'bottom' => 0];

        /**
     * @var array $pageMargins
     */
    private $pageMargins = [];

    public function setDefaultPageMargin(float $top, float $bottom): void
    {
        $this->defaultPageMargin = ['top' => $top, 'bottom' => $bottom];
    }

    public function setPageMargins(array $pageMargins): void
    {
        $this->pageMargins = $pageMargins;
    }

    public function getPageMargin(int $index): array
    {
        if (isset($this->pageMargins[$index])) {
            return $this->pageMargins[$index];
        }
        return $this->defaultPageMargin;
    }

    public function getPageMargins(): array
    {
        return $this->pageMargins;
    }

    public function addPageMargin(float $top, float $bottom): void
    {
        $this->pageMargins[] = [
            'top' => $top,
            'bottom' => $bottom
        ];
    }
}
