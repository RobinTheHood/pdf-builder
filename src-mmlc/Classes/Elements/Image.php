<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;

class Image extends Container
{
    /**
     * @var string $imagePath
     */
    private $imagePath = '';

    public function __construct(string $path)
    {
        parent::__construct();
        $this->setContainerRenderer(new ImageRenderer());
        $this->imagePath = $path;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }
}
