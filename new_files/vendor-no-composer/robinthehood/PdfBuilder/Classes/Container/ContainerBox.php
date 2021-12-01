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
}
