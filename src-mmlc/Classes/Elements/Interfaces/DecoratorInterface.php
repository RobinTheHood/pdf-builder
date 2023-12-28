<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements\Interfaces;

use RobinTheHood\PdfBuilder\Classes\Container\Interfaces\ContainerInterface;

interface DecoratorInterface extends ContainerInterface
{
    public const DECORATION_MODE_NEVER = 0;
    public const DECORATION_MODE_ALWAYS = 1;
    public const DECORATION_MODE_NOT_FIRST = 2;
}
