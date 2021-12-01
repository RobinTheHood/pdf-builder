<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container;

use RobinTheHood\PdfBuilder\Classes\Container\ContainerValue;

class ContainerBox
{
    public $positionX;
    public $positionY;

    public $width;
    public $height;

    public $marginTop;
    public $marginRight;
    public $marginBottom;
    public $marginLeft;

    public $borderTop;
    public $borderRight;
    public $borderBottom;
    public $borderLeft;

    public $paddingTop;
    public $paddingRight;
    public $paddingBottom;
    public $paddingLeft;

    public function __construct()
    {
        $this->positionX = new ContainerValue();
        $this->positionY = new ContainerValue();

        $this->width = new ContainerValue();
        $this->height = new ContainerValue();

        $this->marginTop = new ContainerValue();
        $this->marginRight = new ContainerValue();
        $this->marginBottom = new ContainerValue();
        $this->marginLeft = new ContainerValue();

        $this->borderTop = new ContainerValue();
        $this->borderRight = new ContainerValue();
        $this->borderBottom = new ContainerValue();
        $this->borderLeft = new ContainerValue();

        $this->paddingTop = new ContainerValue();
        $this->paddingRight = new ContainerValue();
        $this->paddingBottom = new ContainerValue();
        $this->paddingLeft = new ContainerValue();
    }

    public function copy(): ContainerBox
    {
        $containerBox = new ContainerBox();
        $containerBox->positionX = $this->positionX->copy();
        $containerBox->positionY = $this->positionY->copy();

        $containerBox->width = $this->width->copy();
        $containerBox->height = $this->height->copy();

        $containerBox->marginTop = $this->marginTop->copy();
        $containerBox->marginRight = $this->marginRight->copy();
        $containerBox->marginBottom = $this->marginRight->copy();
        $containerBox->marginLeft = $this->marginLeft->copy();

        $containerBox->borderTop = $this->borderTop->copy();
        $containerBox->borderRight = $this->borderRight->copy();
        $containerBox->borderBottom = $this->borderRight->copy();
        $containerBox->borderLeft = $this->borderLeft->copy();

        $containerBox->paddingTop = $this->paddingTop->copy();
        $containerBox->paddingRight = $this->paddingRight->copy();
        $containerBox->paddingBottom = $this->paddingRight->copy();
        $containerBox->paddingLeft = $this->paddingLeft->copy();

        return $containerBox;
    }

    public function getMarginBox(): array
    {
        $x = $this->positionX->getValue();
        $y = $this->positionY->getValue();

        $width = $this->marginLeft->getValue()
            + $this->borderLeft->getValue()
            + $this->paddingLeft->getValue()
            + $this->width->getValue()
            + $this->paddingRight->getValue()
            + $this->borderRight->getValue()
            + $this->marginRight->getValue();

        $height = $this->marginTop->getValue()
            + $this->borderTop->getValue()
            + $this->paddingTop->getValue()
            + $this->height->getValue()
            + $this->paddingBottom->getValue()
            + $this->borderBottom->getValue()
            + $this->marginBottom->getValue();

        $boxLines = $this->getBoxLines($x, $y, $width, $height);

        return [
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
            'boxLines' => $boxLines,
        ];
    }

    public function getBorderBox(): array
    {
        $x = $this->positionX->getValue()
            + $this->marginLeft->getValue();

        $y = $this->positionY->getValue()
            + $this->marginTop->getValue();

        $width = $this->borderLeft->getValue()
            + $this->paddingLeft->getValue()
            + $this->width->getValue()
            + $this->paddingRight->getValue()
            + $this->borderRight->getValue();

        $height = $this->borderTop->getValue()
            + $this->paddingTop->getValue()
            + $this->height->getValue()
            + $this->paddingBottom->getValue()
            + $this->borderBottom->getValue();

        $boxLines = $this->getBoxLines($x, $y, $width, $height);

        return [
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
            'boxLines' => $boxLines,
        ];
    }

    public function getPaddingBox(): array
    {
        $x = $this->positionX->getValue()
            + $this->marginLeft->getValue()
            + $this->borderLeft->getValue();

        $y = $this->positionY->getValue()
            + $this->marginTop->getValue()
            + $this->borderTop->getValue();

        $width = $this->paddingLeft->getValue()
            + $this->width->getValue()
            + $this->paddingRight->getValue();

        $height = $this->paddingTop->getValue()
            + $this->height->getValue()
            + $this->paddingBottom->getValue();


        $boxLines = $this->getBoxLines($x, $y, $width, $height);

        return [
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
            'boxLines' => $boxLines,
        ];
    }

    public function getContentBox(): array
    {
        $x = $this->positionX->getValue()
            + $this->marginLeft->getValue()
            + $this->borderLeft->getValue()
            + $this->paddingLeft->getValue();

        $y = $this->positionY->getValue()
            + $this->marginTop->getValue()
            + $this->borderTop->getValue()
            + $this->paddingTop->getValue();

        $width = $this->width->getValue();
        $height = $this->height->getValue();

        $boxLines = $this->getBoxLines($x, $y, $width, $height);

        return [
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
            'boxLines' => $boxLines,
        ];
    }

    private function getBoxLines($x, $y, $width, $height)
    {
        $top = [
            'x1' => $x,
            'y1' => $y,
            'x2' => $x + $width,
            'y2' => $y
        ];

        $right = [
            'x1' => $x + $width,
            'y1' => $y,
            'x2' => $x + $width,
            'y2' => $y + $height
        ];

        $bottom = [
            'x1' => $x,
            'y1' => $y + $height,
            'x2' => $x + $width,
            'y2' => $y + $height,
        ];

        $left = [
            'x1' => $x,
            'y1' => $y,
            'x2' => $x,
            'y2' => $y + $height
        ];

        return [
            'top' => $top,
            'right' => $right,
            'bottom' => $bottom,
            'left' => $left
        ];
    }

    public function getMarginBottom($containers)
    {
        $bottomLine = 0;
        foreach ($containers as $container) {
            $box = $container->getCalcedContainer()->getMarginBox();
            $containBottomLine = $box['y'] + $box['height'];
            if ($containBottomLine > $bottomLine) {
                $bottomLine = $containBottomLine;
            }
        }
        return $bottomLine;
    }
}
