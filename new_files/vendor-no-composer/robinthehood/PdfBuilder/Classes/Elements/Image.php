<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;

class Image extends Container
{
    public function __construct(string $path)
    {
        // Use new Container
        parent::__construct();
        $this->setContainerRenderer(new ImageRenderer());
        $this->imagePath = $path;
    }
}
