<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container\Traits;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;

trait ContainerCopyTrait
{
    public function copy(): ContainerInterface
    {
        $container = new Container();
        $container->containerBox = $this->containerBox->copy();
        return $container;
    }
}
